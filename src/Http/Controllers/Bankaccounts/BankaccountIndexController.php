<?php

namespace IlBronza\Payments\Http\Controllers\Bankaccounts;

use IlBronza\CRUD\Traits\CRUDIndexTrait;
use IlBronza\CRUD\Traits\CRUDPlainIndexTrait;

class BankaccountIndexController extends BankaccountCRUD
{
    use CRUDPlainIndexTrait;
    use CRUDIndexTrait;

    public $allowedMethods = ['index'];

    public function getIndexFieldsArray()
    {
        return config('payments.models.bankaccount.fieldsGroupsFiles.index')::getTracedFieldsGroup();
    }

    public function getRelatedFieldsArray()
    {
        return $this->getIndexFieldsArray();
    }

    public function getIndexElements()
    {
        return $this->getModelClass()::with('bank')->withCount('cards')->get();
    }

    public function addIndexButtons()
    {
        $this->addCardsPackageCrossEntityIndexButtons();
    }
}
