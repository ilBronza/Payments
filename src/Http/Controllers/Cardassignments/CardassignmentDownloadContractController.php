<?php

namespace IlBronza\Payments\Http\Controllers\Cardassignments;

use Barryvdh\DomPDF\Facade\Pdf;
use IlBronza\Payments\Helpers\CardassignmentDownloadContractFilenameHelper;

class CardassignmentDownloadContractController extends CardassignmentCRUD
{
    public $allowedMethods = ['downloadContract'];

    public function downloadContract(string $cardAssignment)
    {
        $cardAssignment = $this->findModel($cardAssignment);

        $cardAssignment->load([
            'card.bankaccount.bank',
            'card.cardtype',
            'card.cardcircuit',
            'card.holder',
            'utilizer',
        ]);

        $pdf = Pdf::loadView('payments::cardassignments.contract', [
            'cardAssignment' => $cardAssignment,
            'card' => $cardAssignment->card,
            'cardcircuit' => $cardAssignment->card->cardcircuit,
            'bank' => $cardAssignment->card->bankaccount->bank,
            'bankaccount' => $cardAssignment->card->bankaccount,
            'holder' => $cardAssignment->card->holder,
            'utilizer' => $cardAssignment->utilizer,
        ]);

        $pdf->setPaper('a4', 'portrait');

        $filenameHelperClass = config(
            'payments.models.cardassignment.helpers.downloadContractFilename',
            CardassignmentDownloadContractFilenameHelper::class
        );

        return $pdf->download($filenameHelperClass::getFilename($cardAssignment));
    }
}
