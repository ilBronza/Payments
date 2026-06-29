<?php

namespace IlBronza\Payments\Http\Controllers\Cardcircuits;

use IlBronza\CRUD\Traits\CRUDShowTrait;

class CardcircuitShowController extends CardcircuitCRUD
{
    use CRUDShowTrait;

    public $allowedMethods = ['show'];

    public function getGenericParametersFile(): ?string
    {
        return config('payments.models.cardcircuit.parametersFiles.show');
    }

    public function show(string $cardcircuit)
    {
        $cardcircuit = $this->findModel($cardcircuit);

        return $this->_show($cardcircuit);
    }
}
