<?php

namespace IlBronza\Payments\Http\Controllers\Cardcircuits;

use IlBronza\CRUD\Traits\CRUDIndexTrait;
use IlBronza\CRUD\Traits\CRUDPlainIndexTrait;

class CardcircuitIndexController extends CardcircuitCRUD
{
    use CRUDPlainIndexTrait;
    use CRUDIndexTrait;

    public $allowedMethods = ['index'];

    public function getIndexFieldsArray()
    {
        return config('payments.models.cardcircuit.fieldsGroupsFiles.index')::getTracedFieldsGroup();
    }

    public function getRelatedFieldsArray()
    {
        return $this->getIndexFieldsArray();
    }

    public function getIndexElements()
    {
        return $this->getModelClass()::withCount('cards')->get();
    }

    public function addIndexButtons()
    {
        $this->addCardsPackageCrossEntityIndexButtons();
    }
}
