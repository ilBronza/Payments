<?php

namespace IlBronza\Payments\Http\Controllers\Cardassignments;

use Illuminate\Support\Facades\DB;

class CardassignmentReassignController extends CardassignmentCRUD
{
    public $allowedMethods = ['reassign'];

    public function reassign(string $cardAssignment)
    {
        $cardAssignment = $this->findModel($cardAssignment);
        $today = now()->startOfDay();

        $newCardAssignment = DB::transaction(function () use ($cardAssignment, $today) {
            if (! $cardAssignment->ends_at || $cardAssignment->ends_at->greaterThanOrEqualTo($today)) {
                $cardAssignment->ends_at = $today;
                $cardAssignment->save();
            }

            $newCardAssignment = $cardAssignment->replicate();
            $newCardAssignment->utilizer_id = null;
            $newCardAssignment->starts_at = $today;
            $newCardAssignment->ends_at = null;
            $newCardAssignment->save();

            return $newCardAssignment;
        });

        return redirect()->to($newCardAssignment->getEditUrl());
    }
}
