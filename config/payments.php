<?php

use IlBronza\Prices\Models\Payments;

return [
	'models' => [
		'paymenttype' => [
			'table' => 'payments__paymenttypes'
		]

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