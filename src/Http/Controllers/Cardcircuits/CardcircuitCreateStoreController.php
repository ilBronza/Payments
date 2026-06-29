<?php

namespace IlBronza\Payments\Http\Controllers\Cardcircuits;

use IlBronza\CRUD\Traits\CRUDCreateStoreTrait;

class CardcircuitCreateStoreController extends CardcircuitCRUD
{
    use CRUDCreateStoreTrait;

    public $allowedMethods = ['create', 'store'];

    public function getGenericParametersFile(): ?string
    {
        return config('payments.models.cardcircuit.parametersFiles.create');
    }
}
