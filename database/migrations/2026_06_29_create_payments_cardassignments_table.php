<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create(config('payments.models.cardassignment.table'), function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('card_id');
            $table->foreign('card_id')->references('id')->on(config('payments.models.card.table'));

            $table->uuid('holder_id');
            $table->foreign('holder_id')->references('id')->on(config('operators.models.operator.table'));

            $table->uuid('utilizer_id');
            $table->foreign('utilizer_id')->references('id')->on(config('operators.models.operator.table'));

            $table->date('starts_at');
            $table->date('ends_at')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(config('payments.models.cardassignment.table'));
    }
};
