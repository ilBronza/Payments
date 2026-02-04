<?php

namespace IlBronza\Payments\Http\Controllers\Paymentables;

use IlBronza\CRUD\Traits\CRUDIndexTrait;
use IlBronza\CRUD\Traits\CRUDPlainIndexTrait;
use IlBronza\Payments\Http\Controllers\Paymentables\PaymentableCRUD;

class PaymentableIndexController extends PaymentableCRUD
{
    use CRUDPlainIndexTrait;
    use CRUDIndexTrait;

    public $allowedMethods = ['index'];

    public function getIndexFieldsArray()
    {
        return config('payments.models.paymentable.fieldsGroupsFiles.index')::getTracedFieldsGroup();
    }

    public function getRelatedFieldsArray()
    {
        return $this->getIndexFieldsArray();
        // return config('payments.models.paymentable.fieldsGroupsFiles.index')::getTracedFieldsGroup();
    }

    public function getIndexElements()
    {
        return $this->getModelClass()::with('paymentable', 'paymenttype')->get();
    }

}
