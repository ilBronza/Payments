<?php

namespace IlBronza\Payments\Http\Controllers\Parameters\Fieldsets;

use IlBronza\Form\Helpers\FieldsetsProvider\FieldsetParametersFile;

class CardCreateStoreFieldsetsParameters extends FieldsetParametersFile
{
    public function _getFieldsetsParameters(): array
    {
        return [
            'base' => [
                'translationPrefix' => 'payments::cards',
                'fields' => [
                    'name' => ['text' => 'string|required|max:255'],
                    'cardtype' => [
                        'type' => 'select',
                        'multiple' => false,
                        'rules' => 'nullable|uuid|exists:' . config('payments.models.cardtype.table') . ',id',
                        'relation' => 'cardtype',
                    ],
                    'cardcircuit' => [
                        'type' => 'select',
                        'multiple' => false,
                        'rules' => 'nullable|uuid|exists:' . config('payments.models.cardcircuit.table') . ',id',
                        'relation' => 'cardcircuit',
                    ],
                    'bankaccount' => [
                        'type' => 'select',
                        'multiple' => false,
                        'rules' => 'nullable|uuid|exists:' . config('payments.models.bankaccount.table') . ',id',
                        'relation' => 'bankaccount',
                    ],
                    'plafond' => ['number' => 'integer|nullable|min:0|max:999999999'],
                    'number' => ['text' => 'string|nullable|max:32|credit_card_number'],
                    'expiring' => ['text' => 'string|nullable|max:32'],
                    'cvv' => ['text' => 'nullable|digits:3'],
                    'active' => ['boolean' => 'boolean|nullable'],
                    'notes' => ['textarea' => 'string|nullable'],
                ],
                'width' => ['1-3@l', '1-2@m'],
            ],
        ];
    }
}
