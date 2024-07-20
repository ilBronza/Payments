<?php

namespace IlBronza\Payments\Http\Controllers\Parameters\Datatables;

use IlBronza\Datatables\Providers\FieldsGroupParametersFile;

class PaymentableFieldsGroupParametersFile extends FieldsGroupParametersFile
{
	static function getFieldsGroup() : array
	{
		return [
            'translationPrefix' => 'payments::fields',
            'fields' => 
            [
                'mySelfSee' => 'links.see',
                'paymenttype.name' => 'flat',

                'paymentable' => 'translatedClassBasename',
                'mySelfSeeTarget.paymentable' => 'links.see',
                'mySelfSeeTargetName.paymentable' => '_fn_getName',

                'mySelfDelete' => 'links.delete'
            ]
        ];
	}
}