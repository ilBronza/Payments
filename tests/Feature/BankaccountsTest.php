<?php

namespace IlBronza\Payments\Tests\Feature;

use IlBronza\Payments\Http\Controllers\Parameters\Fieldsets\BankaccountCreateStoreFieldsetsParameters;
use IlBronza\Payments\Http\Controllers\Parameters\RelationshipsManagers\BankaccountRelationManager;
use IlBronza\Payments\Models\Bank;
use IlBronza\Payments\Models\Bankaccount;
use IlBronza\Payments\Models\Card;
use IlBronza\Payments\Models\Traits\InteractsWithBankaccounts;
use IlBronza\Payments\Tests\TestCase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BankaccountsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config(['crud.broadcast.enabled' => false]);

        (require __DIR__ . '/../../database/migrations/2026_06_29_create_cards_tables.php')->up();
        (require __DIR__ . '/../../database/migrations/2026_07_03_create_bankaccounts_and_link_cards_table.php')->up();
        $this->bankDetailsMigration()->up();

        Schema::create('bankaccount_clients', function (Blueprint $table) {
            $table->uuid('id')->primary();
        });
        Schema::create('bankaccount_companies', function (Blueprint $table) {
            $table->uuid('id')->primary();
        });
        Schema::create('bankaccount_integer_owners', function (Blueprint $table) {
            $table->id();
        });
    }

    protected function bankDetailsMigration()
    {
        return require __DIR__ . '/../../database/migrations/2026_10_10_add_bank_details_and_owner_to_bankaccounts_table.php';
    }

    public function test_accounts_store_bank_details_and_are_scoped_to_the_owner_type_and_id(): void
    {
        $id = (string) Str::uuid();
        $client = BankaccountClient::create(['id' => $id]);
        $otherClient = BankaccountClient::create(['id' => (string) Str::uuid()]);
        $company = BankaccountCompany::create(['id' => $id]);

        $account = $client->bankaccounts()->create([
            'iban' => 'IT60X0542811101000000123456',
            'abi' => '05428',
            'cab' => '00123',
            'account_number' => '000000123456',
        ]);
        $second = $client->bankaccounts()->create(['account_number' => 'second']);
        $otherClient->bankaccounts()->create(['account_number' => 'other-client']);
        $companyAccount = $company->bankaccounts()->create(['account_number' => 'company']);

        $stored = $account->fresh();
        $this->assertSame('05428', $stored->abi);
        $this->assertSame('00123', $stored->cab);
        $this->assertSame('IT60X0542811101000000123456', $stored->iban);
        $this->assertSame('000000123456', $stored->account_number);
        $this->assertSame($stored->iban . ' - ' . $stored->account_number, $stored->name);
        $this->assertTrue($stored->bankaccountable->is($client));
        $this->assertEqualsCanonicalizing([$account->id, $second->id], $client->bankaccounts->modelKeys());
        $this->assertSame([$companyAccount->id], $company->bankaccounts->modelKeys());

        $account->delete();
        $this->assertSame([$second->id], $client->bankaccounts()->get()->modelKeys());
        $this->assertCount(2, $client->bankaccounts()->withTrashed()->get());
    }

    public function test_existing_accounts_can_be_associated_reassigned_and_detached(): void
    {
        $client = BankaccountClient::create(['id' => (string) Str::uuid()]);
        $company = BankaccountCompany::create(['id' => (string) Str::uuid()]);
        $account = Bankaccount::create(['iban' => 'IT60X0542811101000000123456']);
        $this->assertNull($account->bankaccountable);

        $client->bankaccounts()->save($account);
        $this->assertTrue($account->fresh()->bankaccountable->is($client));

        $account->bankaccountable()->associate($company);
        $account->save();
        $this->assertTrue($account->fresh()->bankaccountable->is($company));
        $this->assertCount(0, $client->bankaccounts()->get());

        $account->bankaccountable()->dissociate();
        $account->save();
        $this->assertNull($account->fresh()->bankaccountable_id);
        $this->assertNull($account->fresh()->bankaccountable_type);
        $this->assertNull($account->fresh()->bankaccountable);
        $this->assertCount(0, $company->bankaccounts()->get());
    }

    public function test_integer_owner_keys_and_morph_map_aliases_work_with_eager_loading(): void
    {
        $owner = BankaccountIntegerOwner::create();

        Relation::morphMap(['account-owner' => BankaccountIntegerOwner::class], false);

        try {
            $account = $owner->bankaccounts()->create(['abi' => '00001', 'cab' => '00002']);
            $stored = Bankaccount::with('bankaccountable')->findOrFail($account->id);

            $this->assertSame('account-owner', $stored->bankaccountable_type);
            $this->assertTrue($stored->bankaccountable->is($owner));
            $this->assertSame([$account->id], BankaccountIntegerOwner::with('bankaccounts')->findOrFail($owner->id)->bankaccounts->modelKeys());
        } finally {
            Relation::morphMap([], false);
        }
    }

    public function test_the_trait_uses_the_configured_account_class_and_returns_crud_table_data(): void
    {
        config(['payments.models.bankaccount.class' => ProjectBankaccount::class]);

        $client = BankaccountClient::create(['id' => (string) Str::uuid()]);
        $bank = Bank::make();
        $bank->name = 'Test Bank';
        $bank->save();
        $account = $client->bankaccounts()->create(['bank_id' => $bank->id, 'account_number' => '00001']);
        $client->bankaccounts()->create(['account_number' => '00002']);
        Bankaccount::create(['account_number' => 'unrelated']);
        DB::table(config('payments.models.card.table'))->insert([
            'id' => (string) Str::uuid(), 'name' => 'Test card', 'bankaccount_id' => $account->id,
        ]);

        $this->assertInstanceOf(ProjectBankaccount::class, $account);
        $accounts = $client->getRelatedBankaccountElements();
        $this->assertCount(2, $accounts);
        $related = $accounts->firstWhere('id', $account->id);
        $this->assertInstanceOf(ProjectBankaccount::class, $related);
        $this->assertTrue($related->relationLoaded('bank'));
        $this->assertSame('Test Bank', $related->bank->name);
        $this->assertSame(1, $related->cards_count);
    }

    public function test_migration_and_rollback_preserve_existing_accounts_and_card_links(): void
    {
        $migration = $this->bankDetailsMigration();
        $migration->down();

        $accountId = (string) Str::uuid();
        $cardId = (string) Str::uuid();
        DB::table(config('payments.models.bankaccount.table'))->insert([
            'id' => $accountId, 'iban' => 'IT60X0542811101000000123456', 'account_number' => '000000123456',
        ]);
        DB::table(config('payments.models.card.table'))->insert([
            'id' => $cardId, 'name' => 'Existing card', 'bankaccount_id' => $accountId,
        ]);

        $migration->up();
        $account = Bankaccount::findOrFail($accountId);
        $this->assertNull($account->abi);
        $this->assertNull($account->cab);
        $this->assertNull($account->bankaccountable);
        $this->assertSame('IT60X0542811101000000123456', $account->iban);
        $this->assertSame('000000123456', $account->account_number);
        $this->assertSame($accountId, Card::findOrFail($cardId)->bankaccount->id);

        $migration->down();
        foreach (['abi', 'cab', 'bankaccountable_type', 'bankaccountable_id'] as $column) {
            $this->assertFalse(Schema::hasColumn(config('payments.models.bankaccount.table'), $column));
        }
        $this->assertSame($accountId, Card::findOrFail($cardId)->bankaccount->id);
        $this->assertSame('IT60X0542811101000000123456', Bankaccount::findOrFail($accountId)->iban);
    }

    public function test_crud_fields_validate_optional_five_digit_abi_and_cab(): void
    {
        $fields = (new BankaccountCreateStoreFieldsetsParameters())->_getFieldsetsParameters()['base']['fields'];
        $rules = ['abi' => $fields['abi']['text'], 'cab' => $fields['cab']['text']];

        foreach ([[], ['abi' => null, 'cab' => null], ['abi' => '00123', 'cab' => '05428']] as $data) {
            $this->assertTrue(Validator::make($data, $rules)->passes());
        }

        foreach (['1234', '123456', '12A45', ' 12345', "12345\n", 12345] as $invalid) {
            foreach (['abi', 'cab'] as $field) {
                $this->assertTrue(Validator::make([$field => $invalid], $rules)->fails());
            }
        }
    }

    public function test_owner_show_link_respects_configuration_and_handles_unmanaged_owners(): void
    {
        config(['payments.models.bank.controllers.show' => 'App\\Http\\Controllers\\CustomBankShowController']);
        $account = new Bankaccount();
        $account->setRelation('bankaccountable', new Bank());
        $manager = new BankaccountRelationManager($account);
        $this->assertSame('App\\Http\\Controllers\\CustomBankShowController', $manager->getRelationsParameters()['bankaccountable']);

        foreach ([null, new BankaccountClient()] as $owner) {
            $account->setRelation('bankaccountable', $owner);
            $this->assertSame(['bank', 'cards'], (new BankaccountRelationManager($account))->getRelationshipsNamesArray());
        }
    }
}

class BankaccountClient extends Model
{
    use InteractsWithBankaccounts;

    protected $table = 'bankaccount_clients';
    protected $guarded = [];
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
}

class BankaccountCompany extends BankaccountClient
{
    protected $table = 'bankaccount_companies';
}

class BankaccountIntegerOwner extends Model
{
    use InteractsWithBankaccounts;

    protected $table = 'bankaccount_integer_owners';
    protected $guarded = [];
    public $timestamps = false;
}

class ProjectBankaccount extends Bankaccount
{
}
