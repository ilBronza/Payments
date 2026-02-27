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

	            'confirmed' => [
		            'type' => 'editor.toggle',
		            'width' => '5em'
	            ],
	            'approved' => [
		            'type' => 'editor.toggle',
		            'width' => '5em'
	            ],
	            'sent_payment' => [
		            'type' => 'editor.toggle',
		            'width' => '5em'
	            ],
	            'payment_confirmed' => [
		            'type' => 'editor.toggle',
		            'width' => '5em'
	            ],
	            'exported_at' => [
		            'type' => 'dates.datetime',
		            'width' => '10em'
	            ],
	            'exported_by' => 'flat',

	            'target' => 'relations.belongsTo',
	            'emitter' => 'relations.belongsTo',
	            'passeParToutSupplier.name' => 'flat',
	            'invoiceables' => 'relations.belongsToMany',
	            'deadlines' => 'relations.hasMany',

                'orderrows' => 'payments::orderrows.totals',
                'mySelf.orderrows' => 'payments::orderrows.total',

	            'mySelfDelete' => 'links.delete'
            ]
        ];
	}
}