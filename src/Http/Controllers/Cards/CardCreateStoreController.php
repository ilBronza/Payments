<?php

namespace IlBronza\Payments\Http\Controllers\Cards;

use IlBronza\CRUD\Traits\CRUDCreateStoreTrait;

class CardCreateStoreController extends CardCRUD
{
    use CRUDCreateStoreTrait;

    public $allowedMethods = ['create', 'store'];

    public function getGenericParametersFile(): ?string
    {
        return config('payments.models.card.parametersFiles.create');
    }
}
