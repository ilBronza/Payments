<?php

namespace IlBronza\Payments\Http\Controllers\Invoices;

use IlBronza\CRUD\Traits\CRUDIndexTrait;
use IlBronza\CRUD\Traits\CRUDPlainIndexTrait;

class InvoiceIndexController extends InvoiceCRUD
{
	public $avoidCreateButton = true;
    use CRUDPlainIndexTrait;
    use CRUDIndexTrait;

    public $allowedMethods = ['index'];

    public function getIndexFieldsArray()
    {
        return config('payments.models.invoice.fieldsGroupsFiles.index')::getFieldsGroup();
    }

    public function getRelatedFieldsArray()
    {
        return $this->getIndexFieldsArray();
        // return config('payments.models.invoice.fieldsGroupsFiles.index')::getFieldsGroup();
    }

    public function getIndexElements()
    {
        return $this->getModelClass()::with('target', 'emitter', 'invoiceables')->get();
    }

}
