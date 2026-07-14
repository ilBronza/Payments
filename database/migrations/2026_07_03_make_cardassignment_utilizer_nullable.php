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
        $cardassignmentsTable = config('payments.models.cardassignment.table');
        $cardsTable = config('payments.models.card.table');

        if(Schema::hasColumn($cardassignmentsTable, 'holder_id'))
        {
            DB::table($cardassignmentsTable)
                ->whereNull('utilizer_id')
                ->update([
                    'utilizer_id' => DB::raw('holder_id'),
                ]);
        }
        elseif(Schema::hasColumn($cardsTable, 'holder_id'))
        {
            DB::table($cardassignmentsTable)
                ->whereNull('utilizer_id')
                ->update([
                    'utilizer_id' => DB::raw("(select {$cardsTable}.holder_id from {$cardsTable} where {$cardsTable}.id = {$cardassignmentsTable}.card_id)"),
                ]);
        }

        Schema::table($cardassignmentsTable, function (Blueprint $table) {
            $table->dropForeign(['utilizer_id']);
            $table->uuid('utilizer_id')->nullable(false)->change();
            $table->foreign('utilizer_id')->references('id')->on(config('operators.models.operator.table'));
        });
    }
};
