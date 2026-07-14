<?php

namespace IlBronza\Payments\Http\Controllers\Parameters\Datatables;

use IlBronza\Datatables\Providers\FieldsGroupParametersFile;

class CardFieldsGroupParametersFile extends FieldsGroupParametersFile
{
    static function getFieldsGroup(): array
    {
        $result = [
            'translationPrefix' => 'payments::cards',
            'fields' => [
                'mySelfPrimary' => 'primary',
                'mySelfEdit' => 'links.edit',
                'mySelfSee' => 'links.see',
                'number' => [
                    'type' => 'payments::card.number',
                    'width' => '13em'
                ],
                'holder.name' => [
                    'type' => 'flat',
                    'translatedName' => 'Titolare',
                    'order' => [
                        'type' => 'DESC',
                        'priority' => 100
                    ],
                    'width' => '13em'
                ],
                'cardtype.name' => [
                    'type' => 'flat',
                    'translatedName' => 'Tipologia',
                    'width' => '13em'
                ],
                'cardcircuit.name' => [
                    'type' => 'flat',
                    'translatedName' => 'Circuito',
                    'width' => '9em'
                ],
                'bankaccount.bank.name' => [
                    'type' => 'flat',
                    'translatedName' => 'Banca',
                    'width' => '13em'
                ],
                'bankaccount.iban' => [
                    'type' => 'flat',
                    'translatedName' => 'IBAN',
                    'width' => '20em'
                ],
                'bankaccount.account_number' => [
                    'type' => 'flat',
                    'translatedName' => 'Numero conto',
                ],
                'plafond' => [
                    'type' => 'numbers.price',
                    // 'type' => 'editor.price',
                    'width' => '6em'
                ],
                'expiring' => 'flat',
                'cvv' => [
                    'type' => 'flat',
                ],
                'has_active_assignment' => [
                    'type' => 'boolean',
                    'translatedName' => 'Assegnazione',
                    'width' => '10em',
                ],
                'mySelfDelete' => 'links.delete',
            ],
        ];

        if(! \Auth::user()->hasRole('cardCvv'))
            unset($result['fields']['card.cvv']);

        return $result;
    }
}
