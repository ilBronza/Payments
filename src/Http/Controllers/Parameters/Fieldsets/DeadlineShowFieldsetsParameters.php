<?php

namespace IlBronza\Payments\Http\Controllers\Parameters\Fieldsets;

use IlBronza\Form\Helpers\FieldsetsProvider\FieldsetParametersFile;

class DeadlineShowFieldsetsParameters extends FieldsetParametersFile
{
    public function _getFieldsetsParameters() : array
    {
        return [
            'base' => [
                'translationPrefix' => 'payments::deadlines',
                'fields' => [
                    'invoice' => [
                        'type' => 'select',
                        'multiple' => false,
                        'rules' => 'required|uuid|exists:' . config('payments.models.invoice.table') . ',id',
                        'relation' => 'invoice',
                    ],
                    'due_date' => ['date' => 'date|nullable'],
                    'income' => ['number' => 'numeric|required|min:0|max:999999.99'],
                    'vat' => ['number' => 'numeric|required|min:0|max:999999.99'],
                    'total_cost' => ['number' => 'numeric|required|min:0|max:999999.99'],
                ],
                'width' => ['1-3@l', '1-2@m']
            ],
        ];
    }
}
