<?php

namespace IlBronza\Payments\Http\Controllers\Parameters\Fieldsets;

use IlBronza\Form\Helpers\FieldsetsProvider\FieldsetParametersFile;

class PaymenttypeCreateStoreFieldsetsParameters extends FieldsetParametersFile
{
    public function _getFieldsetsParameters() : array
    {
        return [
            'package' => [
                'translationPrefix' => 'payments::fields',
                'fields' => [
                    'name' => ['text' => 'string|required'],
                ],
                'width' => ["1-3@l", '1-2@m']
            ]
        ];
    }
}
