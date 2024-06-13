<?php

use IlBronza\Payments\Models\Paymenttime;
use IlBronza\Payments\Models\Paymenttype;
use IlBronza\Prices\Models\Payments;

return [
	'models' => [
		'paymenttype' => [
			'table' => 'payments__paymenttypes',
			'class' => Paymenttype::class
		],
		'paymenttime' => [
			'table' => 'payments__paymenttimes',
			'class' => Paymenttime::class
		],
		'paymentable' => [
			'table' => 'payments__paymentables',
		],





		'payment' => [
			'table' => 'payments__payments',
		],
		'paymentstatus' => [
			'table' => 'payments__paymentstatuses',
		],

		// 'price' => [
		// 	'class' => Price::class,
		// 	'model' => Price::class,
		// 	'table' => 'prices',
		// 	'fieldsGroupsFiles' => [
        //         'index' => PriceFieldsGroupParametersFile::class,
		// 	]
		// ]
	]
];