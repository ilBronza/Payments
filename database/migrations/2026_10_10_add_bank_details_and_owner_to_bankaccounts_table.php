<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table(config('payments.models.bankaccount.table'), function (Blueprint $table) {
            $table->string('abi', 5)->nullable();
            $table->string('cab', 5)->nullable();
            $table->string('bankaccountable_type')->nullable();
            // String keys support UUID, ULID and integer owners in the same table.
            $table->string('bankaccountable_id', 36)->nullable();
            $table->index(['bankaccountable_type', 'bankaccountable_id'], 'payments_bankaccountable_index');
        });
    }

    public function down(): void
    {
        Schema::table(config('payments.models.bankaccount.table'), function (Blueprint $table) {
            $table->dropMorphs('bankaccountable', 'payments_bankaccountable_index');
            $table->dropColumn(['abi', 'cab']);
        });
    }
};
