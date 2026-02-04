<?php

namespace IlBronza\Payments\Http\Controllers\Invoices;

use IlBronza\CRUD\Traits\CRUDIndexTrait;
use IlBronza\CRUD\Traits\CRUDPlainIndexTrait;

use function config;

class InvoiceIndexController extends InvoiceCRUD
{
	public $avoidCreateButton = true;
    use CRUDPlainIndexTrait;
    use CRUDIndexTrait;

    public $allowedMethods = ['index'];

    public function getIndexFieldsArray()
    {
		//InvoiceFieldsGroupParametersFile
        return config('payments.models.invoice.fieldsGroupsFiles.index')::getTracedFieldsGroup();
    }

    public function getRelatedFieldsArray()
    {
        return $this->getIndexFieldsArray();
        // return config('payments.models.invoice.fieldsGroupsFiles.index')::getTracedFieldsGroup();
    }

    public function getIndexElements()
    {
        return $this->getModelClass()::with([
			'target',
	        'emitter.target',
	        'invoiceables.target'
        ])->get();
    }

}
