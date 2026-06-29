<?php

namespace IlBronza\Payments\Http\Controllers\Cardtypes;

use IlBronza\CRUD\Traits\CRUDIndexTrait;
use IlBronza\CRUD\Traits\CRUDPlainIndexTrait;

class CardtypeIndexController extends CardtypeCRUD
{
    use CRUDPlainIndexTrait;
    use CRUDIndexTrait;

    public $allowedMethods = ['index'];

    public function getIndexFieldsArray()
    {
        return config('payments.models.cardtype.fieldsGroupsFiles.index')::getTracedFieldsGroup();
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
