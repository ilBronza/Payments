<?php

namespace IlBronza\Payments\Http\Controllers\Banks;

use IlBronza\CRUD\Traits\CRUDIndexTrait;
use IlBronza\CRUD\Traits\CRUDPlainIndexTrait;

class BankIndexController extends BankCRUD
{
    use CRUDPlainIndexTrait;
    use CRUDIndexTrait;

    public $allowedMethods = ['index'];

    public function getIndexFieldsArray()
    {
        return config('payments.models.bank.fieldsGroupsFiles.index')::getTracedFieldsGroup();
    }

    public function getRelatedFieldsArray()
    {
        return $this->getIndexFieldsArray();
    }

    public function getIndexElements()
    {
        return $this->getModelClass()::withCount('bankaccounts')->get();
    }

    public function addIndexButtons()
    {
        $this->addCardsPackageCrossEntityIndexButtons();
    }
}
