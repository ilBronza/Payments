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
	            'amount' => 'numbers.number2',

	            'target' => 'relations.belongsTo',
	            'emitter' => 'relations.belongsTo',
	            'passeParToutSupplier.name' => 'flat',
	            'invoiceables' => 'relations.belongsToMany',

                'orderrows' => 'payments::orderrows.totals',
                'mySelf.orderrows' => 'payments::orderrows.total',

	            'mySelfDelete' => 'links.delete'
            ]
        ];
	}
}