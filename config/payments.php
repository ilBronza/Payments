<?php

use IlBronza\Payments\Helpers\CardassignmentDownloadContractFilenameHelper;
use IlBronza\Payments\Http\Controllers\Bankaccounts\BankaccountCreateStoreController;
use IlBronza\Payments\Http\Controllers\Bankaccounts\BankaccountDestroyController;
use IlBronza\Payments\Http\Controllers\Bankaccounts\BankaccountEditUpdateController;
use IlBronza\Payments\Http\Controllers\Bankaccounts\BankaccountIndexController;
use IlBronza\Payments\Http\Controllers\Bankaccounts\BankaccountShowController;
use IlBronza\Payments\Http\Controllers\Banks\BankCreateStoreController;
use IlBronza\Payments\Http\Controllers\Banks\BankDestroyController;
use IlBronza\Payments\Http\Controllers\Banks\BankEditUpdateController;
use IlBronza\Payments\Http\Controllers\Banks\BankIndexController;
use IlBronza\Payments\Http\Controllers\Banks\BankShowController;
use IlBronza\Payments\Http\Controllers\Cardassignments\CardassignmentCreateStoreController;
use IlBronza\Payments\Http\Controllers\Cardassignments\CardassignmentDeleteMediaController;
use IlBronza\Payments\Http\Controllers\Cardassignments\CardassignmentDestroyController;
use IlBronza\Payments\Http\Controllers\Cardassignments\CardassignmentDownloadContractController;
use IlBronza\Payments\Http\Controllers\Cardassignments\CardassignmentEditUpdateController;
use IlBronza\Payments\Http\Controllers\Cardassignments\CardassignmentHistoryIndexController;
use IlBronza\Payments\Http\Controllers\Cardassignments\CardassignmentIndexController;
use IlBronza\Payments\Http\Controllers\Cardassignments\CardassignmentInlineCreateController;
use IlBronza\Payments\Http\Controllers\Cardassignments\CardassignmentInlineEditController;
use IlBronza\Payments\Http\Controllers\Cardassignments\CardassignmentReassignController;
use IlBronza\Payments\Http\Controllers\Cardassignments\CardassignmentShowController;
use IlBronza\Payments\Http\Controllers\Cardcircuits\CardcircuitCreateStoreController;
use IlBronza\Payments\Http\Controllers\Cardcircuits\CardcircuitDestroyController;
use IlBronza\Payments\Http\Controllers\Cardcircuits\CardcircuitEditUpdateController;
use IlBronza\Payments\Http\Controllers\Cardcircuits\CardcircuitIndexController;
use IlBronza\Payments\Http\Controllers\Cardcircuits\CardcircuitShowController;
use IlBronza\Payments\Http\Controllers\Cards\CardCreateStoreController;
use IlBronza\Payments\Http\Controllers\Cards\CardDestroyController;
use IlBronza\Payments\Http\Controllers\Cards\CardEditUpdateController;
use IlBronza\Payments\Http\Controllers\Cards\CardIndexController;
use IlBronza\Payments\Http\Controllers\Cards\CardShowController;
use IlBronza\Payments\Http\Controllers\Cardtypes\CardtypeCreateStoreController;
use IlBronza\Payments\Http\Controllers\Cardtypes\CardtypeDestroyController;
use IlBronza\Payments\Http\Controllers\Cardtypes\CardtypeEditUpdateController;
use IlBronza\Payments\Http\Controllers\Cardtypes\CardtypeIndexController;
use IlBronza\Payments\Http\Controllers\Cardtypes\CardtypeShowController;
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
use IlBronza\Payments\Http\Controllers\Parameters\Datatables\BankFieldsGroupParametersFile;
use IlBronza\Payments\Http\Controllers\Parameters\Datatables\BankaccountFieldsGroupParametersFile;
use IlBronza\Payments\Http\Controllers\Parameters\Datatables\CardFieldsGroupParametersFile;
use IlBronza\Payments\Http\Controllers\Parameters\Datatables\CardassignmentByCardFieldsGroupParametersFile;
use IlBronza\Payments\Http\Controllers\Parameters\Datatables\CardassignmentFieldsGroupParametersFile;
use IlBronza\Payments\Http\Controllers\Parameters\Datatables\CardcircuitFieldsGroupParametersFile;
use IlBronza\Payments\Http\Controllers\Parameters\Datatables\CardtypeFieldsGroupParametersFile;
use IlBronza\Payments\Http\Controllers\Parameters\Datatables\DeadlineFieldsGroupParametersFile;
use IlBronza\Payments\Http\Controllers\Parameters\Datatables\InvoiceFieldsGroupParametersFile;
use IlBronza\Payments\Http\Controllers\Parameters\Datatables\InvoiceDetailFieldsGroupParametersFile;
use IlBronza\Payments\Http\Controllers\Parameters\Datatables\InvoiceableFieldsGroupParametersFile;
use IlBronza\Payments\Http\Controllers\Parameters\Datatables\PaymentableFieldsGroupParametersFile;
use IlBronza\Payments\Http\Controllers\Parameters\Datatables\PaymenttypeFieldsGroupParametersFile;
use IlBronza\Payments\Http\Controllers\Parameters\Fieldsets\BankCreateStoreFieldsetsParameters;
use IlBronza\Payments\Http\Controllers\Parameters\Fieldsets\BankaccountCreateStoreFieldsetsParameters;
use IlBronza\Payments\Http\Controllers\Parameters\Fieldsets\CardCreateStoreFieldsetsParameters;
use IlBronza\Payments\Http\Controllers\Parameters\Fieldsets\CardassignmentCreateStoreFieldsetsParameters;
use IlBronza\Payments\Http\Controllers\Parameters\Fieldsets\CardassignmentEditUpdateFieldsetsParameters;
use IlBronza\Payments\Http\Controllers\Parameters\Fieldsets\CardcircuitCreateStoreFieldsetsParameters;
use IlBronza\Payments\Http\Controllers\Parameters\Fieldsets\CardtypeCreateStoreFieldsetsParameters;
use IlBronza\Payments\Http\Controllers\Parameters\Fieldsets\DeadlineShowFieldsetsParameters;
use IlBronza\Payments\Http\Controllers\Parameters\Fieldsets\InvoiceShowFieldsetsParameters;
use IlBronza\Payments\Http\Controllers\Parameters\Fieldsets\InvoiceableShowFieldsetsParameters;
use IlBronza\Payments\Http\Controllers\Parameters\Fieldsets\PaymentableCreateStoreFieldsetsParameters;
use IlBronza\Payments\Http\Controllers\Parameters\Fieldsets\PaymenttypeCreateStoreFieldsetsParameters;
use IlBronza\Payments\Http\Controllers\Parameters\RelationshipsManagers\BankRelationManager;
use IlBronza\Payments\Http\Controllers\Parameters\RelationshipsManagers\BankaccountRelationManager;
use IlBronza\Payments\Http\Controllers\Parameters\RelationshipsManagers\CardRelationManager;
use IlBronza\Payments\Http\Controllers\Parameters\RelationshipsManagers\CardassignmentRelationManager;
use IlBronza\Payments\Http\Controllers\Parameters\RelationshipsManagers\CardcircuitRelationManager;
use IlBronza\Payments\Http\Controllers\Parameters\RelationshipsManagers\CardtypeRelationManager;
use IlBronza\Payments\Http\Controllers\Parameters\RelationshipsManagers\InvoiceRelationManager;
use IlBronza\Payments\Http\Controllers\Parameters\RelationshipsManagers\DeadlineRelationManager;
use IlBronza\Payments\Http\Controllers\Parameters\RelationshipsManagers\InvoiceableRelationManager;
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
use IlBronza\Payments\Models\Bank;
use IlBronza\Payments\Models\Bankaccount;
use IlBronza\Payments\Models\Card;
use IlBronza\Payments\Models\CardAssignment;
use IlBronza\Payments\Models\Cardcircuit;
use IlBronza\Payments\Models\Cardtype;
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
        'paymentsManager',
    ],

    'routeRoles' => [
        'ibPaymentscards.index' => [
            'paymentsManager',
            'cardAssignment',
        ],
    ],

    'datatableFieldWidths' => [
        'links' => [
            'datatableFieldConfirm' => 'auto'
        ],
        'card' => [
            'datatableFieldNumber' => '12em'
        ]
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
        'card' => [
            'table' => 'payments__cards',
            'class' => Card::class,
            'fieldsGroupsFiles' => [
                'index' => CardFieldsGroupParametersFile::class,
            ],
            'parametersFiles' => [
                'create' => CardCreateStoreFieldsetsParameters::class,
                'show' => CardCreateStoreFieldsetsParameters::class,
                'edit' => CardCreateStoreFieldsetsParameters::class,
            ],
            'relationshipsManagerClasses' => [
                'show' => CardRelationManager::class,
            ],
            'controllers' => [
                'index' => CardIndexController::class,
                'create' => CardCreateStoreController::class,
                'store' => CardCreateStoreController::class,
                'show' => CardShowController::class,
                'edit' => CardEditUpdateController::class,
                'update' => CardEditUpdateController::class,
                'destroy' => CardDestroyController::class,
            ],
        ],
        'cardassignment' => [
            'table' => 'payments__cardassignments',
            'class' => CardAssignment::class,
            'helpers' => [
                'downloadContractFilename' => CardassignmentDownloadContractFilenameHelper::class,
            ],
            'fieldsGroupsFiles' => [
                'index' => CardassignmentFieldsGroupParametersFile::class,
                'related' => CardassignmentByCardFieldsGroupParametersFile::class,
            ],
            'parametersFiles' => [
                'create' => CardassignmentCreateStoreFieldsetsParameters::class,
                'show' => CardassignmentEditUpdateFieldsetsParameters::class,
                'edit' => CardassignmentEditUpdateFieldsetsParameters::class,
            ],
            'relationshipsManagerClasses' => [
                'show' => CardassignmentRelationManager::class,
            ],
            'controllers' => [
                'index' => CardassignmentIndexController::class,
                'history' => CardassignmentHistoryIndexController::class,
                'inlineCreate' => CardassignmentInlineCreateController::class,
                'inlineEdit' => CardassignmentInlineEditController::class,
                'create' => CardassignmentCreateStoreController::class,
                'store' => CardassignmentCreateStoreController::class,
                'show' => CardassignmentShowController::class,
                'downloadContract' => CardassignmentDownloadContractController::class,
                'deleteMedia' => CardassignmentDeleteMediaController::class,
                'reassign' => CardassignmentReassignController::class,
                'edit' => CardassignmentEditUpdateController::class,
                'update' => CardassignmentEditUpdateController::class,
                'destroy' => CardassignmentDestroyController::class,
            ],
        ],
        'cardtype' => [
            'table' => 'payments__cardtypes',
            'class' => Cardtype::class,
            'fieldsGroupsFiles' => [
                'index' => CardtypeFieldsGroupParametersFile::class,
            ],
            'parametersFiles' => [
                'create' => CardtypeCreateStoreFieldsetsParameters::class,
                'show' => CardtypeCreateStoreFieldsetsParameters::class,
                'edit' => CardtypeCreateStoreFieldsetsParameters::class,
            ],
            'relationshipsManagerClasses' => [
                'show' => CardtypeRelationManager::class,
            ],
            'controllers' => [
                'index' => CardtypeIndexController::class,
                'create' => CardtypeCreateStoreController::class,
                'store' => CardtypeCreateStoreController::class,
                'show' => CardtypeShowController::class,
                'edit' => CardtypeEditUpdateController::class,
                'update' => CardtypeEditUpdateController::class,
                'destroy' => CardtypeDestroyController::class,
            ],
        ],
        'cardcircuit' => [
            'table' => 'payments__cardcircuits',
            'class' => Cardcircuit::class,
            'fieldsGroupsFiles' => [
                'index' => CardcircuitFieldsGroupParametersFile::class,
            ],
            'parametersFiles' => [
                'create' => CardcircuitCreateStoreFieldsetsParameters::class,
                'show' => CardcircuitCreateStoreFieldsetsParameters::class,
                'edit' => CardcircuitCreateStoreFieldsetsParameters::class,
            ],
            'relationshipsManagerClasses' => [
                'show' => CardcircuitRelationManager::class,
            ],
            'controllers' => [
                'index' => CardcircuitIndexController::class,
                'create' => CardcircuitCreateStoreController::class,
                'store' => CardcircuitCreateStoreController::class,
                'show' => CardcircuitShowController::class,
                'edit' => CardcircuitEditUpdateController::class,
                'update' => CardcircuitEditUpdateController::class,
                'destroy' => CardcircuitDestroyController::class,
            ],
        ],
        'bank' => [
            'table' => 'payments__banks',
            'class' => Bank::class,
            'fieldsGroupsFiles' => [
                'index' => BankFieldsGroupParametersFile::class,
            ],
            'parametersFiles' => [
                'create' => BankCreateStoreFieldsetsParameters::class,
                'show' => BankCreateStoreFieldsetsParameters::class,
                'edit' => BankCreateStoreFieldsetsParameters::class,
            ],
            'relationshipsManagerClasses' => [
                'show' => BankRelationManager::class,
            ],
            'controllers' => [
                'index' => BankIndexController::class,
                'create' => BankCreateStoreController::class,
                'store' => BankCreateStoreController::class,
                'show' => BankShowController::class,
                'edit' => BankEditUpdateController::class,
                'update' => BankEditUpdateController::class,
                'destroy' => BankDestroyController::class,
            ],
        ],
        'bankaccount' => [
            'table' => 'payments__bankaccounts',
            'class' => Bankaccount::class,
            'fieldsGroupsFiles' => [
                'index' => BankaccountFieldsGroupParametersFile::class,
            ],
            'parametersFiles' => [
                'create' => BankaccountCreateStoreFieldsetsParameters::class,
                'show' => BankaccountCreateStoreFieldsetsParameters::class,
                'edit' => BankaccountCreateStoreFieldsetsParameters::class,
            ],
            'relationshipsManagerClasses' => [
                'show' => BankaccountRelationManager::class,
            ],
            'controllers' => [
                'index' => BankaccountIndexController::class,
                'create' => BankaccountCreateStoreController::class,
                'store' => BankaccountCreateStoreController::class,
                'show' => BankaccountShowController::class,
                'edit' => BankaccountEditUpdateController::class,
                'update' => BankaccountEditUpdateController::class,
                'destroy' => BankaccountDestroyController::class,
            ],
        ],
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
			'relationshipsManagerClasses' => [
				'show' => DeadlineRelationManager::class,
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
			'fieldsGroupsFiles' => [
				'related' => InvoiceDetailFieldsGroupParametersFile::class,
			],
		],

		'invoiceable' => [
			'class' => Invoiceable::class,
			'table' => 'payments__invoiceables',
			'fieldsGroupsFiles' => [
				'index' => InvoiceableFieldsGroupParametersFile::class,
			],
			'parametersFiles' => [
				'show' => InvoiceableShowFieldsetsParameters::class
			],
			'relationshipsManagerClasses' => [
				'show' => InvoiceableRelationManager::class,
			],
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
