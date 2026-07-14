<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        $cardsTable = config('payments.models.card.table');
        $cardassignmentsTable = config('payments.models.cardassignment.table');
        $operatorsTable = config('operators.models.operator.table');

        if(! Schema::hasColumn($cardsTable, 'holder_id'))
        {
            Schema::table($cardsTable, function (Blueprint $table) use ($operatorsTable)
            {
                $table->uuid('holder_id')->nullable()->after('bankaccount_id');
                $table->foreign('holder_id')->references('id')->on($operatorsTable);
            });
        }

        if(! Schema::hasColumn($cardassignmentsTable, 'holder_id'))
            return;

        $this->copyCardassignmentHoldersToCards($cardsTable, $cardassignmentsTable, true);
        $this->copyCardassignmentHoldersToCards($cardsTable, $cardassignmentsTable, false);

        Schema::table($cardassignmentsTable, function (Blueprint $table)
        {
            $table->dropForeign(['holder_id']);
            $table->dropColumn('holder_id');
        });
    }

    public function down()
    {
        $cardsTable = config('payments.models.card.table');
        $cardassignmentsTable = config('payments.models.cardassignment.table');
        $operatorsTable = config('operators.models.operator.table');

        if(! Schema::hasColumn($cardassignmentsTable, 'holder_id'))
        {
            Schema::table($cardassignmentsTable, function (Blueprint $table) use ($operatorsTable)
            {
                $table->uuid('holder_id')->nullable()->after('card_id');
                $table->foreign('holder_id')->references('id')->on($operatorsTable);
            });
        }

        if(Schema::hasColumn($cardsTable, 'holder_id'))
        {
            DB::table($cardassignmentsTable)
                ->join($cardsTable, "{$cardassignmentsTable}.card_id", '=', "{$cardsTable}.id")
                ->whereNotNull("{$cardsTable}.holder_id")
                ->select("{$cardassignmentsTable}.id", "{$cardsTable}.holder_id")
                ->orderBy("{$cardassignmentsTable}.id")
                ->get()
                ->each(function ($cardassignment) use ($cardassignmentsTable)
                {
                    DB::table($cardassignmentsTable)
                        ->where('id', $cardassignment->id)
                        ->update([
                            'holder_id' => $cardassignment->holder_id,
                            'updated_at' => now(),
                        ]);
                });

            Schema::table($cardsTable, function (Blueprint $table)
            {
                $table->dropForeign(['holder_id']);
                $table->dropColumn('holder_id');
            });
        }
    }

    private function copyCardassignmentHoldersToCards(
        string $cardsTable,
        string $cardassignmentsTable,
        bool $onlyCurrentAssignments
    ): void
    {
        $query = DB::table($cardassignmentsTable)
            ->whereNotNull('card_id')
            ->whereNotNull('holder_id')
            ->select('card_id', 'holder_id')
            ->orderByDesc('starts_at')
            ->orderByDesc('updated_at');

        if($onlyCurrentAssignments)
        {
            $query->where(function ($query)
            {
                $query->whereNull('ends_at')
                    ->orWhere('ends_at', '>', now()->toDateString());
            });
        }

        $query->get()->each(function ($cardassignment) use ($cardsTable)
        {
            DB::table($cardsTable)
                ->where('id', $cardassignment->card_id)
                ->whereNull('holder_id')
                ->update([
                    'holder_id' => $cardassignment->holder_id,
                    'updated_at' => now(),
                ]);
        });
    }
};
