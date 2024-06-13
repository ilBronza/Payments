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
        Schema::create(config('payments.models.paymenttype.table'), function (Blueprint $table) {
            // $table->uuid('id')->primary();
            $table->id();

            $table->string('name');

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create(config('payments.models.paymenttime.table'), function (Blueprint $table) {
            // $table->uuid('id')->primary();
            $table->id();

            $table->string('name');
            $table->unsignedInteger('days')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create(config('payments.models.paymentable.table'), function (Blueprint $table) {
            // $table->uuid('id')->primary();
            $table->id();

            $table->unsignedBigInteger('paymenttype_id')->nullable();
            $table->foreign('paymenttype_id')->references('id')->on(config('payments.models.paymenttype.table'));

            $table->unsignedBigInteger('paymenttime_id')->nullable();
            $table->foreign('paymenttime_id')->references('id')->on(config('payments.models.paymenttime.table'));

            $table->uuidMorphs('paymentable');

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
        Schema::dropIfExists(config('payments.models.paymentable.table'));
        Schema::dropIfExists(config('payments.models.paymenttime.table'));
        Schema::dropIfExists(config('payments.models.paymenttype.table'));
    }
};
