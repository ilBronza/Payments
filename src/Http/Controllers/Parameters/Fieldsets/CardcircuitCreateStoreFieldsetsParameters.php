<?php

namespace IlBronza\Payments\Http\Controllers\Parameters\Fieldsets;

use IlBronza\Form\Helpers\FieldsetsProvider\FieldsetParametersFile;

class CardcircuitCreateStoreFieldsetsParameters extends FieldsetParametersFile
{
    public function _getFieldsetsParameters(): array
    {
        return [
            'base' => [
                'translationPrefix' => 'payments::cardcircuits',
                'fields' => [
                    'name' => ['text' => 'string|required|max:255'],
                ],
                'width' => ['1-3@l', '1-2@m'],
            ],
        ];
    }
}
