<?php

namespace IlBronza\Payments\Http\Controllers\Parameters\Fieldsets;

use IlBronza\Form\Helpers\FieldsetsProvider\FieldsetParametersFile;

class BankaccountCreateStoreFieldsetsParameters extends FieldsetParametersFile
{
    public function _getFieldsetsParameters(): array
    {
        return [
            'base' => [
                'translationPrefix' => 'payments::bankaccounts',
                'fields' => [
                    'iban' => ['text' => 'string|nullable|max:34'],
                    'abi' => ['text' => 'nullable|string|regex:/\A[0-9]{5}\z/'],
                    'cab' => ['text' => 'nullable|string|regex:/\A[0-9]{5}\z/'],
                    'account_number' => ['text' => 'string|nullable|max:64'],
                    'bank' => [
                        'type' => 'select',
                        'multiple' => false,
                        'rules' => 'nullable|uuid|exists:' . config('payments.models.bank.table') . ',id',
                        'relation' => 'bank',
                    ],
                ],
                'width' => ['1-3@l', '1-2@m'],
            ],
        ];
    }
}
