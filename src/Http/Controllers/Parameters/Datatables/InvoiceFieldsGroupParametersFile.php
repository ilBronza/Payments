<?php

namespace IlBronza\Payments\Http\Controllers\Parameters\Datatables;

use IlBronza\Datatables\Providers\FieldsGroupParametersFile;

class InvoiceFieldsGroupParametersFile extends FieldsGroupParametersFile
{
	static function getFieldsGroup() : array
	{
		return [
            'translationPrefix' => 'payments::invoices',
            'fields' => 
            [
                'mySelfSee' => 'links.see',
                'name' => 'flat',
	            'date' => [
					'type' => 'dates.date',
		            'order' => [
						'priority' => 100,
			            'type' => 'DESC'
		            ]
	            ],
	            'description' => 'flat',
//	            'amount' => 'flat',

	            'target' => 'relations.belongsTo',
	            'emitter' => 'relations.belongsTo',
	            'invoiceables' => 'relations.belongsToMany',

	            'mySelfDelete' => 'links.delete'
            ]
        ];
	}
}