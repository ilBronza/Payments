<?php

namespace IlBronza\Payments\Http\Controllers\Parameters\Datatables;

use IlBronza\Datatables\Providers\FieldsGroupParametersFile;

class CardassignmentByCardFieldsGroupParametersFile extends FieldsGroupParametersFile
{
    static function getFieldsGroup(): array
    {
        $result = [
            'translationPrefix' => 'payments::cardassignments',
            'fields' => [
                'mySelfPrimary' => 'primary',
                'utilizer.name' => [
                    'type' => 'flat',
                    'translatedName' => 'Utilizzatore',
                ],
                'starts_at' => 'dates.date',
                'ends_at' => 'dates.date',
                'mySelfContractDownload' => [
                    'type' => 'links.link',
                    'faIcon' => 'print',
                    'function' => 'getDownloadContractUrl'
                ],
                'mySelfDelete' => 'links.delete',
            ],
        ];

        return $result;
    }
}
