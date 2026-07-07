<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table(config('payments.models.cardassignment.table'), function (Blueprint $table) {
            $table->string('signed_contract_file', 128)->nullable()->after('ends_at');
        });
    }

    public function down()
    {
        Schema::table(config('payments.models.cardassignment.table'), function (Blueprint $table) {
            $table->dropColumn('signed_contract_file');
        });
    }
};
