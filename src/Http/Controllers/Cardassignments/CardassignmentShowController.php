<?php

namespace IlBronza\Payments\Http\Controllers\Cardassignments;

use IlBronza\CRUD\Traits\CRUDShowTrait;

class CardassignmentShowController extends CardassignmentCRUD
{
    use CRUDShowTrait;

    public $allowedMethods = ['show'];

    public function getGenericParametersFile(): ?string
    {
        return config('payments.models.cardassignment.parametersFiles.show');
    }

    public function show(string $cardassignment)
    {
        $cardassignment = $this->findModel($cardassignment);

        return $this->_show($cardassignment);
    }
}
