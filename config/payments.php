<?php

use IlBronza\Payments\Http\Controllers\Parameters\Datatables\PaymentableFieldsGroupParametersFile;
use IlBronza\Payments\Http\Controllers\Parameters\Datatables\PaymenttypeFieldsGroupParametersFile;
use IlBronza\Payments\Http\Controllers\Parameters\Fieldsets\PaymentableCreateStoreFieldsetsParameters;
use IlBronza\Payments\Http\Controllers\Parameters\Fieldsets\PaymenttypeCreateStoreFieldsetsParameters;
use IlBronza\Payments\Http\Controllers\Parameters\RelationshipsManagers\PaymentableRelationManager;
use IlBronza\Payments\Http\Controllers\Parameters\RelationshipsManagers\PaymenttypeRelationManager;
use IlBronza\Payments\Http\Controllers\Paymentables\PaymentableCreateStoreController;
use IlBronza\Payments\Http\Controllers\Paymentables\PaymentableDestroyController;
use IlBronza\Payments\Http\Controllers\Paymentables\PaymentableEditUpdateController;
use IlBronza\Payments\Http\Controllers\Paymentables\PaymentableIndexController;
use IlBronza\Payments\Http\Controllers\Paymentables\PaymentableShowController;
use IlBronza\Payments\Http\Controllers\Paymenttypes\PaymenttypeCreateStoreController;
use IlBronza\Payments\Http\Controllers\Paymenttypes\PaymenttypeDestroyController;
use IlBronza\Payments\Http\Controllers\Paymenttypes\PaymenttypeEditUpdateController;
use IlBronza\Payments\Http\Controllers\Paymenttypes\PaymenttypeIndexController;
use IlBronza\Payments\Http\Controllers\Paymenttypes\PaymenttypeShowController;
use IlBronza\Payments\Models\Paymentable;
use IlBronza\Payments\Models\Paymenttime;
use IlBronza\Payments\Models\Paymenttype;
use IlBronza\Prices\Models\Payments;

return [
	'enabled' => true,

    'routePrefix' => 'ibPayments',

	'models' => [
		'paymenttype' => [
			'table' => 'payments__paymenttypes',
			'class' => Paymenttype::class,
            'fieldsGroupsFiles' => [
                'index' => PaymenttypeFieldsGroupParametersFile::class
            ],
            'parametersFiles' => [
                'create' => PaymenttypeCreateStoreFieldsetsParameters::class,
                'show' => PaymenttypeCreateStoreFieldsetsParameters::class
            ],
            'relationshipsManagerClasses' => [
                'show' => PaymenttypeRelationManager::class
            ],
            'controllers' => [
                'index' => PaymenttypeIndexController::class,
                'create' => PaymenttypeCreateStoreController::class,
                'store' => PaymenttypeCreateStoreController::class,
                'show' => PaymenttypeShowController::class,
                'edit' => PaymenttypeEditUpdateController::class,
                'update' => PaymenttypeEditUpdateController::class,
                'destroy' => PaymenttypeDestroyController::class,
            ]
		],
		'paymenttime' => [
			'table' => 'payments__paymenttimes',
			'class' => Paymenttime::class
		],
		'paymentable' => [
			'table' => 'payments__paymentables',
			'class' => Paymentable::class,
            'fieldsGroupsFiles' => [
                'index' => PaymentableFieldsGroupParametersFile::class
            ],
            'parametersFiles' => [
                'create' => PaymentableCreateStoreFieldsetsParameters::class,
                'show' => PaymentableCreateStoreFieldsetsParameters::class
            ],
            'relationshipsManagerClasses' => [
                'show' => PaymentableRelationManager::class
            ],
            'controllers' => [
                'index' => PaymentableIndexController::class,
                'create' => PaymentableCreateStoreController::class,
                'store' => PaymentableCreateStoreController::class,
                'show' => PaymentableShowController::class,
                'edit' => PaymentableEditUpdateController::class,
                'update' => PaymentableEditUpdateController::class,
                'destroy' => PaymentableDestroyController::class,
            ]
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