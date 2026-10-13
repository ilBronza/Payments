<?php

namespace IlBronza\Payments\Tests\Feature;

use IlBronza\Payments\Models\InvoicingData;
use IlBronza\Payments\Models\Traits\InteractsWithInvoicingData;
use IlBronza\Payments\Tests\TestCase;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class InvoicingDataTest extends TestCase
{
    protected function defineDatabaseMigrations()
    {
        parent::defineDatabaseMigrations();

        foreach (['invoicing_data_owners', 'other_invoicing_data_owners'] as $table) {
            Schema::create($table, function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->timestamps();
            });
        }

        $this->migration()->up();
    }

    protected function setUp(): void
    {
        parent::setUp();

        config(['crud.broadcast.enabled' => false]);
    }

    private function migration()
    {
        return require __DIR__ . '/../../database/migrations/2026_10_10_create_invoicing_data_table.php';
    }

    public function test_fiscal_fields_and_boolean_casts_persist_through_the_owner_relation(): void
    {
        $owner = InvoicingDataOwner::create();
        $data = $owner->invoicingData()->create([
            'vat' => '01234567890',
            'rea_number' => 'MI-0012345',
            'istat_code' => '015146',
            'ateco_code' => '62.10.00',
            'pubblica_amministrazione' => 1,
            'sdi' => 'ABC1234',
            'split_payment' => 1,
        ])->refresh();

        $this->assertTrue(Str::isUuid($data->getKey()));
        $this->assertFalse($data->getIncrementing());
        $this->assertSame('01234567890', $data->vat);
        $this->assertSame('MI-0012345', $data->rea_number);
        $this->assertSame('015146', $data->istat_code);
        $this->assertSame('62.10.00', $data->ateco_code);
        $this->assertSame('ABC1234', $data->sdi);
        $this->assertTrue($data->pubblica_amministrazione);
        $this->assertTrue($data->split_payment);
        $this->assertTrue($data->invoicingDataable->is($owner));

        $updated = $owner->invoicingData()->updateOrCreate([], [
            'pubblica_amministrazione' => false,
            'split_payment' => false,
        ]);

        $this->assertSame($data->getKey(), $updated->getKey());
        $this->assertSame(1, $owner->invoicingData()->count());
        $this->assertFalse($updated->fresh()->pubblica_amministrazione);
        $this->assertFalse($updated->fresh()->split_payment);
    }

    public function test_optional_codes_and_boolean_defaults_are_available_after_reload(): void
    {
        $data = new InvoicingData();
        $this->assertFalse($data->pubblica_amministrazione);
        $this->assertFalse($data->split_payment);

        $data = InvoicingDataOwner::create()->invoicingData()->create()->refresh();

        foreach (['vat', 'rea_number', 'istat_code', 'ateco_code', 'sdi'] as $field) {
            $this->assertNull($data->{$field});
        }

        $this->assertFalse($data->pubblica_amministrazione);
        $this->assertFalse($data->split_payment);
    }

    public function test_relations_distinguish_owner_types_with_the_same_uuid_and_support_eager_loading(): void
    {
        $owner = InvoicingDataOwner::create();
        $other = OtherInvoicingDataOwner::create(['id' => $owner->getKey()]);
        $unrelated = InvoicingDataOwner::create();

        $data = $owner->invoicingData()->create(['vat' => '01234567890']);
        $otherData = $other->invoicingData()->create(['vat' => '00987654321']);
        $unrelated->invoicingData()->create(['vat' => '00123456789']);

        $loaded = InvoicingDataOwner::with('invoicingData')->findOrFail($owner->getKey());
        $this->assertTrue($loaded->relationLoaded('invoicingData'));
        $this->assertTrue($loaded->invoicingData->is($data));
        $this->assertTrue($other->fresh()->invoicingData->is($otherData));
        $this->assertTrue($otherData->fresh()->invoicingDataable->is($other));
    }

    public function test_data_can_be_associated_with_a_uuid_model_without_the_trait_using_a_morph_map(): void
    {
        $previousMap = Relation::morphMap();
        Relation::morphMap(['invoicing_owner' => UnmanagedInvoicingDataOwner::class], false);

        try {
            $owner = UnmanagedInvoicingDataOwner::create();
            $data = new InvoicingData(['sdi' => 'ABC123']);
            $data->invoicingDataable()->associate($owner);
            $this->assertTrue($data->relationLoaded('invoicingDataable'));
            $this->assertSame($owner, $data->invoicingDataable);
            $data->save();

            $this->assertSame('invoicing_owner', $data->fresh()->invoicing_dataable_type);
            $this->assertSame($owner->getKey(), $data->invoicing_dataable_id);
            $this->assertTrue($data->fresh()->invoicingDataable->is($owner));
        } finally {
            Relation::morphMap($previousMap, false);
        }
    }

    public function test_migration_and_relation_respect_the_configured_table_and_model_class(): void
    {
        $migration = $this->migration();
        $migration->down();
        $this->assertFalse(Schema::hasTable('payments__invoicing_data'));

        config([
            'payments.models.invoicingData.table' => 'custom_invoicing_data',
            'payments.models.invoicingData.class' => CustomInvoicingData::class,
        ]);
        $migration->up();

        $data = InvoicingDataOwner::create()->invoicingData()->create(['vat' => '01234567890']);
        $this->assertInstanceOf(CustomInvoicingData::class, $data);
        $this->assertSame('custom_invoicing_data', $data->getTable());
        $this->assertSame('01234567890', $data->fresh()->vat);

        $migration->down();
        $this->assertFalse(Schema::hasTable('custom_invoicing_data'));
    }
}

class InvoicingDataOwner extends Model
{
    use HasUuids;
    use InteractsWithInvoicingData;

    protected $table = 'invoicing_data_owners';

    protected $guarded = [];
}

class OtherInvoicingDataOwner extends InvoicingDataOwner
{
    protected $table = 'other_invoicing_data_owners';
}

class UnmanagedInvoicingDataOwner extends Model
{
    use HasUuids;

    protected $table = 'invoicing_data_owners';
}

class CustomInvoicingData extends InvoicingData
{
}
