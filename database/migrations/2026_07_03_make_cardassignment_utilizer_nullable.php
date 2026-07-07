<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table(config('payments.models.cardassignment.table'), function (Blueprint $table) {
            $table->dropForeign(['utilizer_id']);
            $table->uuid('utilizer_id')->nullable()->change();
            $table->foreign('utilizer_id')->references('id')->on(config('operators.models.operator.table'));
        });
    }

    public function down()
    {
        DB::table(config('payments.models.cardassignment.table'))
            ->whereNull('utilizer_id')
            ->update([
                'utilizer_id' => DB::raw('holder_id'),
            ]);

        Schema::table(config('payments.models.cardassignment.table'), function (Blueprint $table) {
            $table->dropForeign(['utilizer_id']);
            $table->uuid('utilizer_id')->nullable(false)->change();
            $table->foreign('utilizer_id')->references('id')->on(config('operators.models.operator.table'));
        });
    }
};
