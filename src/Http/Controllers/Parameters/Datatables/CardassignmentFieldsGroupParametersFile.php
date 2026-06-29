<?php

namespace IlBronza\Payments\Http\Controllers\Parameters\Datatables;

use IlBronza\Datatables\Providers\FieldsGroupParametersFile;

class CardassignmentFieldsGroupParametersFile extends FieldsGroupParametersFile
{
    static function getFieldsGroup(): array
    {
        return [
            'translationPrefix' => 'payments::cardassignments',
            'fields' => [
                'mySelfPrimary' => 'primary',
                'mySelfEdit' => 'links.edit',
                'mySelfSee' => 'links.see',
                'card.name' => [
                    'type' => 'flat',
                    'translatedName' => 'Carta',
                ],
                'holder.name' => [
                    'type' => 'flat',
                    'translatedName' => 'Intestatario',
                ],
                'utilizer.name' => [
                    'type' => 'flat',
                    'translatedName' => 'Utilizzatore',
                ],
                'starts_at' => 'dates.date',
                'ends_at' => 'dates.date',
                'mySelfDelete' => 'links.delete',
            ],
        ];
    }
}
