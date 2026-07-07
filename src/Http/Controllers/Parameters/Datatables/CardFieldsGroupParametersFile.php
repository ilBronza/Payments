<?php

namespace IlBronza\Payments\Http\Controllers\Parameters\Datatables;

use IlBronza\Datatables\Providers\FieldsGroupParametersFile;

class CardFieldsGroupParametersFile extends FieldsGroupParametersFile
{
    static function getFieldsGroup(): array
    {
        return [
            'translationPrefix' => 'payments::cards',
            'fields' => [
                'mySelfPrimary' => 'primary',
                // 'mySelfEdit' => 'links.edit',
                'mySelfSee' => 'links.see',
                'name' => 'flat',
                'cardtype.name' => [
                    'type' => 'flat',
                    'translatedName' => 'Tipologia',
                ],
                'cardcircuit.name' => [
                    'type' => 'flat',
                    'translatedName' => 'Circuito',
                ],
                'bankaccount.bank.name' => [
                    'type' => 'flat',
                    'translatedName' => 'Banca',
                ],
                'bankaccount.iban' => [
                    'type' => 'flat',
                    'translatedName' => 'IBAN',
                ],
                'bankaccount.account_number' => [
                    'type' => 'flat',
                    'translatedName' => 'Numero conto',
                ],
                'plafond' => [
                    'type' => 'numbers.price',
                    'width' => '6em'
                ],
                'number' => 'payments::card.number',
                'expiring' => 'flat',
                'active' => 'boolean',
                'mySelfDelete' => 'links.delete',
            ],
        ];
    }
}
