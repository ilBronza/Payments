<?php

namespace IlBronza\Payments\Http\Controllers\Parameters\Datatables;

use IlBronza\Datatables\Providers\FieldsGroupParametersFile;

class BankaccountFieldsGroupParametersFile extends FieldsGroupParametersFile
{
    static function getFieldsGroup(): array
    {
        return [
            'translationPrefix' => 'payments::bankaccounts',
            'fields' => [
                'mySelfPrimary' => 'primary',
                'mySelfEdit' => 'links.edit',
                'mySelfSee' => 'links.see',
                'iban' => 'flat',
                'abi' => 'flat',
                'cab' => 'flat',
                'account_number' => 'flat',
                'bank.name' => [
                    'type' => 'flat',
                    'translatedName' => 'Banca',
                ],
                'cards_count' => 'flat',
                'mySelfDelete' => 'links.delete',
            ],
        ];
    }
}
