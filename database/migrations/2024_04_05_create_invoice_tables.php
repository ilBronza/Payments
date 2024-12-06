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
        Schema::create(config('payments.models.invoice.table'), function (Blueprint $table) {
            $table->uuid('id')->primary();

	        $table->string('name')->nullable();
			$table->timestamp('date')->nullable();

			$table->text('description')->nullable();

	        $table->decimal('amount', 8, 2)->nullable();
	        $table->decimal('vat', 8, 2)->nullable();

			$table->text('parameters')->nullable();

	        $table->nullableUuidMorphs('emitter');
	        $table->nullableUuidMorphs('target');

	        $table->softDeletes();
            $table->timestamps();
        });

        Schema::create(config('payments.models.invoiceable.table'), function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->nullableUuidMorphs('target');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('payments.models.invoice.table'));
        Schema::dropIfExists(config('payments.models.invoiceable.table'));
    }
};
