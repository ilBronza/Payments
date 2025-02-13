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
		    $table->dropForeign(['emitter_id']);

		    $table->foreign('emitter_id')->references('id')->on(config('products.models.supplier.table'));
	    });
	}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
};
