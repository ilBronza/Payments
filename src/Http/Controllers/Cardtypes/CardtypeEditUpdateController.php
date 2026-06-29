<?php

namespace IlBronza\Payments\Http\Controllers\Cardtypes;

use IlBronza\CRUD\Traits\CRUDEditUpdateTrait;
use Illuminate\Http\Request;

class CardtypeEditUpdateController extends CardtypeCRUD
{
    use CRUDEditUpdateTrait;

    public $allowedMethods = ['edit', 'update'];

    public function getGenericParametersFile(): ?string
    {
        return config('payments.models.cardtype.parametersFiles.edit');
    }

    public function edit(string $cardtype)
    {
        $cardtype = $this->findModel($cardtype);

        return $this->_edit($cardtype);
    }

    public function update(Request $request, $cardtype)
    {
        $cardtype = $this->findModel($cardtype);

        return $this->_update($request, $cardtype);
    }
}
