<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create(config('payments.models.cardtype.table'), function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create(config('payments.models.cardcircuit.table'), function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create(config('payments.models.bank.table'), function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create(config('payments.models.card.table'), function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('name');

            $table->uuid('cardtype_id')->nullable();
            $table->foreign('cardtype_id')->references('id')->on(config('payments.models.cardtype.table'));

            $table->uuid('cardcircuit_id')->nullable();
            $table->foreign('cardcircuit_id')->references('id')->on(config('payments.models.cardcircuit.table'));

            $table->uuid('bank_id')->nullable();
            $table->foreign('bank_id')->references('id')->on(config('payments.models.bank.table'));

            $table->decimal('plafond', 12, 2)->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('number')->nullable();
            $table->string('expiring')->nullable();
            $table->string('cvv', 3)->nullable();
            $table->boolean('active')->default(true);
            $table->text('notes')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(config('payments.models.card.table'));
        Schema::dropIfExists(config('payments.models.bank.table'));
        Schema::dropIfExists(config('payments.models.cardcircuit.table'));
        Schema::dropIfExists(config('payments.models.cardtype.table'));
    }
};
