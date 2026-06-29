<?php

namespace IlBronza\Payments\Http\Controllers\Cards;

use IlBronza\CRUD\Traits\CRUDEditUpdateTrait;
use Illuminate\Http\Request;

class CardEditUpdateController extends CardCRUD
{
    use CRUDEditUpdateTrait;

    public $allowedMethods = ['edit', 'update'];

    public function getGenericParametersFile(): ?string
    {
        return config('payments.models.card.parametersFiles.edit');
    }

    public function edit(string $card)
    {
        $card = $this->findModel($card);

        return $this->_edit($card);
    }

    public function update(Request $request, $card)
    {
        $card = $this->findModel($card);

        return $this->_update($request, $card);
    }
}
