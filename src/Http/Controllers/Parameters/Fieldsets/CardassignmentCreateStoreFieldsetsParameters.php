<?php

namespace IlBronza\Payments\Http\Controllers\Parameters\Fieldsets;

use IlBronza\Form\Helpers\FieldsetsProvider\FieldsetParametersFile;

class CardassignmentCreateStoreFieldsetsParameters extends FieldsetParametersFile
{
    public function _getFieldsetsParameters(): array
    {
        return [
            'base' => [
                'translationPrefix' => 'payments::cardassignments',
                'fields' => [
                    'card_id' => [
                        'type' => 'select',
                        'multiple' => false,
                        'rules' => 'string|required|exists:' . config('payments.models.card.table') . ',id',
                        'relation' => 'card',
                    ],
                    'holder_id' => [
                        'type' => 'select',
                        'multiple' => false,
                        'rules' => 'string|required|exists:' . config('operators.models.operator.table') . ',id',
                        'relation' => 'holder',
                    ],
                    'utilizer_id' => [
                        'type' => 'select',
                        'multiple' => false,
                        'rules' => 'string|required|exists:' . config('operators.models.operator.table') . ',id',
                        'relation' => 'utilizer',
                    ],
                    'starts_at' => ['date' => 'date|required'],
                    'ends_at' => ['date' => 'date|nullable|after_or_equal:starts_at'],
                ],
                'width' => ['1-3@l', '1-2@m'],
            ],
        ];
    }
}
