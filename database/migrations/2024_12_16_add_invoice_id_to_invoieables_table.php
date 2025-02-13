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
        Schema::table(config('payments.models.invoiceable.table'), function (Blueprint $table) {
			$table->uuid('invoice_id')->after('id');
			$table->foreign('invoice_id')->references('id')->on(config('payments.models.invoice.table'));
			$table->string('notes')->nullable()->after('invoice_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::table(config('payments.models.invoiceable.table'), function (Blueprint $table) {
			$table->dropForeign(['invoice_id']);
		    $table->dropColumn('invoice_id');
		    $table->dropColumn('notes');
	    });
    }
};
