<?php

namespace IlBronza\Payments\Http\Controllers\Parameters\Datatables;

use IlBronza\Datatables\Providers\FieldsGroupParametersFile;

class CardassignmentFieldsGroupParametersFile extends FieldsGroupParametersFile
{
    static function getFieldsGroup(): array
    {
        $result = [
            'translationPrefix' => 'payments::cardassignments',
            'fields' => [
                'mySelfPrimary' => 'primary',
                'mySelfEdit' => 'links.edit',
                'mySelfSee' => 'links.see',
                'card.name' => [
                    'type' => 'flat',
                    'translatedName' => 'Carta',
                ],
                'mySelfReassign' => [
                    'type' => 'links.link',
                    'function' => 'getReassignUrl',
                    'textMethod' => 'getReassignText',
                    'width' => '12em',
                    // 'confirmMessage' => 'payments::cardassignments.reassign_confirmation',
                ],
                'card.cardtype.name' => 'flat',
                'card.cardcircuit.name' => 'flat',
                'card.bankaccount.bank.name' => 'flat',
                'card.plafond' => 'flat',
                'card.bankaccount.account_number' => 'flat',
                'card.number' => 'flat',
                'card.expiring' => 'flat',
                'card.cvv' => [
                    'type' => 'flat',
                ],

                'holder.name' => [
                    'type' => 'flat',
                    'translatedName' => 'Titolare',
                ],
                'utilizer.name' => [
                    'type' => 'flat',
                    'translatedName' => 'Utilizzatore',
                ],
                'starts_at' => 'dates.date',
                'ends_at' => 'dates.date',
                // 'is_valid' => 'boolean',
                'mySelfDelete' => 'links.delete',
            ],
        ];

        if(! \Auth::user()->hasRole('cardCvv'))
            unset($result['fields']['card.cvv']);

        return $result;
    }
}
