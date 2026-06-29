<?php

namespace IlBronza\Payments\Http\Controllers\Cardcircuits;

use IlBronza\CRUD\Traits\CRUDEditUpdateTrait;
use Illuminate\Http\Request;

class CardcircuitEditUpdateController extends CardcircuitCRUD
{
    use CRUDEditUpdateTrait;

    public $allowedMethods = ['edit', 'update'];

    public function getGenericParametersFile(): ?string
    {
        return config('payments.models.cardcircuit.parametersFiles.edit');
    }

    public function edit(string $cardcircuit)
    {
        $cardcircuit = $this->findModel($cardcircuit);

        return $this->_edit($cardcircuit);
    }

    public function update(Request $request, $cardcircuit)
    {
        $cardcircuit = $this->findModel($cardcircuit);

        return $this->_update($request, $cardcircuit);
    }
}
