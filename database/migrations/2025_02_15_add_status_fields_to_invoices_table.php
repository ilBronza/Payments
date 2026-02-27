<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(config('payments.models.invoice.table'), function (Blueprint $table) {
            $table->boolean('confirmed')->default(false)->after('parameters');
            $table->boolean('approved')->default(false)->after('confirmed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(config('payments.models.invoice.table'), function (Blueprint $table) {
            $table->dropColumn([
                'confirmed',
                'approved',
            ]);
        });
    }
};
