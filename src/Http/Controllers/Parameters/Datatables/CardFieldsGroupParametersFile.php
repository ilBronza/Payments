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
                'mySelfEdit' => 'links.edit',
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
                'bank.name' => [
                    'type' => 'flat',
                    'translatedName' => 'Banca',
                ],
                'plafond' => 'flat',
                'bank_account_number' => 'flat',
                'number' => 'flat',
                'expiring' => 'flat',
                'active' => 'boolean',
                'mySelfDelete' => 'links.delete',
            ],
        ];
    }
}
