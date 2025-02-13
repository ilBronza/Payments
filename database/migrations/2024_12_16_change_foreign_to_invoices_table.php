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
	        $table->dropColumn('target_type');
	        $table->dropColumn('emitter_type');

	        $table->foreign('target_id')->references('id')->on(config('clients.models.client.table'));
	        $table->foreign('emitter_id')->references('id')->on(config('clients.models.client.table'));
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

		    $table->dropForeign(['target_id']);
		    $table->dropForeign(['emitter_id']);

		    $table->string('target_type', 64);
		    $table->string('emitter_type', 64);
	    });
    }
};
