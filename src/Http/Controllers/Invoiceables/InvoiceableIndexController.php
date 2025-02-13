<?php

namespace IlBronza\Payments\Http\Controllers\Invoiceables;

use IlBronza\CRUD\Traits\CRUDIndexTrait;
use IlBronza\CRUD\Traits\CRUDPlainIndexTrait;

class InvoiceableIndexController extends InvoiceableCRUD
{
    use CRUDPlainIndexTrait;
    use CRUDIndexTrait;

    public $allowedMethods = ['index'];

    public function getIndexFieldsArray()
    {
        return config('payments.models.invoiceable.fieldsGroupsFiles.index')::getFieldsGroup();
    }

    public function getRelatedFieldsArray()
    {
        return $this->getIndexFieldsArray();
        // return config('payments.models.invoiceable.fieldsGroupsFiles.index')::getFieldsGroup();
    }

    public function getIndexElements()
    {
        return $this->getModelClass()::with('invoice')->get();
    }

}
