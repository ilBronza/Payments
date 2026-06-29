<?php

namespace IlBronza\Payments\Http\Controllers\Cardassignments;

use IlBronza\CRUD\Traits\CRUDCreateStoreTrait;

class CardassignmentCreateStoreController extends CardassignmentCRUD
{
    use CRUDCreateStoreTrait;

    public $allowedMethods = ['create', 'store'];

    public function getGenericParametersFile(): ?string
    {
        return config('payments.models.cardassignment.parametersFiles.create');
    }
}
