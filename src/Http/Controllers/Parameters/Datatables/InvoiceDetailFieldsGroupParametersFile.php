<?php

namespace IlBronza\Payments\Http\Controllers\Parameters\Datatables;

use IlBronza\Datatables\Providers\FieldsGroupParametersFile;

class InvoiceDetailFieldsGroupParametersFile extends FieldsGroupParametersFile
{
    static function getFieldsGroup(): array
    {
        return [
            'translationPrefix' => 'payments::invoiceDetails',
            'fields' => [
                'sorting_index' => [
                    'type' => 'flat',
                    'order' => ['priority' => 100, 'type' => 'ASC'],
                ],
                'description' => 'flat',
                'quantity' => ['type' => 'numbers.formatted', 'decimals' => 4],
                'unit_price' => 'numbers.number2',
                'total_price' => 'numbers.number2',
                'vat_rate' => 'numbers.number2',
            ],
        ];
    }
}
