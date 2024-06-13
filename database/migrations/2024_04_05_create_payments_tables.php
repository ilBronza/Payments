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
        Schema::create(config('payments.models.paymentstatus.table'), function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('slug');

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create(config('payments.models.payment.table'), function (Blueprint $table) {
            $table->uuid()->primary();

            $table->nullableUuidMorphs('source');
            $table->nullableUuidMorphs('reason');
            $table->nullableUuidMorphs('destination');

            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on(config('category.models.category.table'));

            $table->decimal('amount', 10, 2)->nullable();

            $table->unsignedBigInteger('paymentstatus_id')->nullable();
            $table->foreign('paymentstatus_id')->references('id')->on(config('payments.models.paymentstatus.table'));

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
        Schema::dropIfExists(config('payments.models.payment.table'));
        Schema::dropIfExists(config('payments.models.paymentstatus.table'));
    }
};
