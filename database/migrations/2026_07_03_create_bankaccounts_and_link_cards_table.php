<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up()
    {
        Schema::create(config('payments.models.bankaccount.table'), function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->nullable();
            $table->string('iban', 34)->nullable();
            $table->string('account_number', 64)->nullable();

            $table->uuid('bank_id')->nullable();
            $table->foreign('bank_id')->references('id')->on(config('payments.models.bank.table'));

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table(config('payments.models.card.table'), function (Blueprint $table) {
            $table->uuid('bankaccount_id')->nullable()->after('bank_id');
            $table->foreign('bankaccount_id')->references('id')->on(config('payments.models.bankaccount.table'));
        });

        $cardsTable = config('payments.models.card.table');
        $bankaccountsTable = config('payments.models.bankaccount.table');

        if (! Schema::hasColumn($cardsTable, 'bank_id')) {
            return;
        }

        $bankaccounts = [];

        DB::table($cardsTable)
            ->whereNull('bankaccount_id')
            ->where(function ($query) {
                $query->whereNotNull('bank_id')
                    ->orWhereNotNull('bank_account_number');
            })
            ->select('id', 'bank_id', 'bank_account_number')
            ->orderBy('id')
            ->get()
            ->each(function ($card) use (&$bankaccounts, $bankaccountsTable, $cardsTable) {
                $key = ($card->bank_id ?? '') . '|' . ($card->bank_account_number ?? '');

                if (! isset($bankaccounts[$key])) {
                    $bankaccounts[$key] = (string) Str::uuid();

                    DB::table($bankaccountsTable)->insert([
                        'id' => $bankaccounts[$key],
                        'name' => $card->bank_account_number ?? $card->bank_id,
                        'iban' => null,
                        'account_number' => $card->bank_account_number,
                        'bank_id' => $card->bank_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                DB::table($cardsTable)
                    ->where('id', $card->id)
                    ->update([
                        'bankaccount_id' => $bankaccounts[$key],
                        'updated_at' => now(),
                    ]);
            });
    }

    public function down()
    {
        Schema::table(config('payments.models.card.table'), function (Blueprint $table) {
            $table->dropForeign(['bankaccount_id']);
            $table->dropColumn('bankaccount_id');
        });

        Schema::dropIfExists(config('payments.models.bankaccount.table'));
    }
};
