<?php

use IlBronza\Payments\Http\Controllers\Deadlines\DeadlineCreateStoreController;
use IlBronza\Payments\Http\Controllers\Deadlines\DeadlineDestroyController;
use IlBronza\Payments\Http\Controllers\Deadlines\DeadlineEditUpdateController;
use IlBronza\Payments\Http\Controllers\Deadlines\DeadlineExportBankTransfersIndexController;
use IlBronza\Payments\Http\Controllers\Deadlines\DeadlineExportCsvController;
use IlBronza\Payments\Http\Controllers\Deadlines\DeadlineIndexController;
use IlBronza\Payments\Http\Controllers\Deadlines\DeadlineShowController;
use IlBronza\Payments\Http\Controllers\Invoiceables\InvoiceableCreateStoreController;
use IlBronza\Payments\Http\Controllers\Invoiceables\InvoiceableDestroyController;
use IlBronza\Payments\Http\Controllers\Invoiceables\InvoiceableEditUpdateController;
use IlBronza\Payments\Http\Controllers\Invoiceables\InvoiceableIndexController;
use IlBronza\Payments\Http\Controllers\Invoiceables\InvoiceableShowController;
use IlBronza\Payments\Http\Controllers\Invoices\InvoiceByYearIndexController;
use IlBronza\Payments\Http\Controllers\Invoices\InvoiceCreateStoreController;
use IlBronza\Payments\Http\Controllers\Invoices\InvoiceDestroyController;
use IlBronza\Payments\Http\Controllers\Invoices\InvoiceEditUpdateController;
use IlBronza\Payments\Http\Controllers\Invoices\InvoiceExportCsvController;
use IlBronza\Payments\Http\Controllers\Invoices\InvoiceGeneratePdfController;
use IlBronza\Payments\Http\Controllers\Invoices\InvoiceIndexController;
use IlBronza\Payments\Http\Controllers\Invoices\InvoiceShowController;
use IlBronza\Payments\Http\Controllers\Parameters\Datatables\DeadlineFieldsGroupParametersFile;
use IlBronza\Payments\Http\Controllers\Parameters\Datatables\InvoiceFieldsGroupParametersFile;
use IlBronza\Payments\Http\Controllers\Parameters\Datatables\PaymentableFieldsGroupParametersFile;
use IlBronza\Payments\Http\Controllers\Parameters\Datatables\PaymenttypeFieldsGroupParametersFile;
use IlBronza\Payments\Http\Controllers\Parameters\Fieldsets\DeadlineShowFieldsetsParameters;
use IlBronza\Payments\Http\Controllers\Parameters\Fieldsets\InvoiceShowFieldsetsParameters;
use IlBronza\Payments\Http\Controllers\Parameters\Fieldsets\InvoiceableShowFieldsetsParameters;
use IlBronza\Payments\Http\Controllers\Parameters\Fieldsets\PaymentableCreateStoreFieldsetsParameters;
use IlBronza\Payments\Http\Controllers\Parameters\Fieldsets\PaymenttypeCreateStoreFieldsetsParameters;
use IlBronza\Payments\Http\Controllers\Parameters\RelationshipsManagers\InvoiceRelationManager;
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
use IlBronza\Payments\Models\Deadline;
use IlBronza\Payments\Models\Invoice;
use IlBronza\Payments\Models\InvoiceDetail;
use IlBronza\Payments\Models\Invoiceable;
use IlBronza\Payments\Models\Paymentable;
use IlBronza\Payments\Models\Paymenttime;
use IlBronza\Payments\Models\Paymenttype;
use IlBronza\Prices\Models\Payments;

return [
	'enabled' => true,

    'routePrefix' => 'ibPayments',

    'defaultRoles' => [
        'superadmin',
        'administrator',
        'payments',
    ],

    'routeRoles' => [
    ],

	'invoice' => [
		'defaults' => [
			'company_name' => '',
			'currency' => 'EUR',
			'document_type' => 'TD01 (fattura)',
			'fiscal_regime' => 'RF19 (Regime forfettario)',
			'fiscal_operation_description' => "Operazione senza applicazione dell'Iva ai sensi dell'art. 1 commi 54-89, l. n. 190/2014 così come modificato dalla l. n. 208/2015 e dalla l. n. 145/2018",
			'vat_exigibility_code' => 'N2.2',
			'default_unit_of_measure' => 'NR',
			'payment_method' => 'MP05 (bonifico)',
		],
	],

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

		'invoice' => [
			'class' => Invoice::class,
			'table' => 'payments__invoices',
			'fieldsGroupsFiles' => [
				'index' => InvoiceFieldsGroupParametersFile::class
			],
			'parametersFiles' => [
//				'create' => InvoiceCreateStoreFieldsetsParameters::class,
				'show' => InvoiceShowFieldsetsParameters::class,
				'edit' => InvoiceShowFieldsetsParameters::class
			],
			'relationshipsManagerClasses' => [
				'show' => InvoiceRelationManager::class
			],
			'controllers' => [
				'index' => InvoiceIndexController::class,
				'generatePdf' => InvoiceGeneratePdfController::class,
				'byYear' => InvoiceByYearIndexController::class,
				'create' => InvoiceCreateStoreController::class,
				'store' => InvoiceCreateStoreController::class,
				'show' => InvoiceShowController::class,
				'edit' => InvoiceEditUpdateController::class,
				'update' => InvoiceEditUpdateController::class,
				'destroy' => InvoiceDestroyController::class,
			]
		],

		'deadline' => [
			'class' => Deadline::class,
			'table' => 'payments__deadlines',
			'fieldsGroupsFiles' => [
				'index' => DeadlineFieldsGroupParametersFile::class
			],
			'parametersFiles' => [
				'show' => DeadlineShowFieldsetsParameters::class,
				'create' => DeadlineShowFieldsetsParameters::class,
				'edit' => DeadlineShowFieldsetsParameters::class,
			],
			'controllers' => [
				'index' => DeadlineIndexController::class,
				'create' => DeadlineCreateStoreController::class,
				'store' => DeadlineCreateStoreController::class,
				'show' => DeadlineShowController::class,
				'edit' => DeadlineEditUpdateController::class,
				'update' => DeadlineEditUpdateController::class,
				'destroy' => DeadlineDestroyController::class,
				'exportBankTransefers' => DeadlineExportBankTransfersIndexController::class,
				'exportCsv' => DeadlineExportCsvController::class,
			]
		],

		'invoiceDetail' => [
			'class' => InvoiceDetail::class,
			'table' => 'payments__invoice_details',
		],

		'invoiceable' => [
			'class' => Invoiceable::class,
			'table' => 'payments__invoiceables',
			'parametersFiles' => [
				'show' => InvoiceableShowFieldsetsParameters::class
			],
//			'relationshipsManagerClasses' => [
//				'show' => InvoiceableRelationManager::class
//			],
			'controllers' => [
				'index' => InvoiceableIndexController::class,
				'create' => InvoiceableCreateStoreController::class,
				'store' => InvoiceableCreateStoreController::class,
				'show' => InvoiceableShowController::class,
				'edit' => InvoiceableEditUpdateController::class,
				'update' => InvoiceableEditUpdateController::class,
				'destroy' => InvoiceableDestroyController::class,
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