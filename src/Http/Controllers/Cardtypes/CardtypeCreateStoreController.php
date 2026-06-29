<?php

namespace IlBronza\Payments\Http\Controllers\Cardtypes;

use IlBronza\CRUD\Traits\CRUDCreateStoreTrait;

class CardtypeCreateStoreController extends CardtypeCRUD
{
    use CRUDCreateStoreTrait;

    public $allowedMethods = ['create', 'store'];

    public function getGenericParametersFile(): ?string
    {
        return config('payments.models.cardtype.parametersFiles.create');
    }
}
