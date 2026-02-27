<?php

namespace IlBronza\Payments\Http\Controllers\Parameters\Datatables;

use IlBronza\Datatables\Providers\FieldsGroupParametersFile;

class DeadlineFieldsGroupParametersFile extends FieldsGroupParametersFile
{
    static function getFieldsGroup() : array
    {
        return [
            'translationPrefix' => 'payments::deadlines',
            'fields' => [
                'mySelfSee' => 'links.see',
                'invoice' => 'relations.belongsTo',
                'invoice.emitter.name' => 'flat',
                'due_date' => [
                    'type' => 'dates.date',
                    'order' => [
                        'priority' => 100,
                        'type' => 'ASC'
                    ]
                ],
                'income' => 'numbers.number2',
                'vat' => 'numbers.number2',
                'total_cost' => 'numbers.number2',
                'mySelfDelete' => 'links.delete'
            ]
        ];
    }
}
