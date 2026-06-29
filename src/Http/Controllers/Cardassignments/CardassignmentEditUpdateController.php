<?php

namespace IlBronza\Payments\Http\Controllers\Cardassignments;

use IlBronza\CRUD\Traits\CRUDEditUpdateTrait;
use Illuminate\Http\Request;

class CardassignmentEditUpdateController extends CardassignmentCRUD
{
    use CRUDEditUpdateTrait;

    public $allowedMethods = ['edit', 'update'];

    public function getGenericParametersFile(): ?string
    {
        return config('payments.models.cardassignment.parametersFiles.edit');
    }

    public function edit(string $cardassignment)
    {
        $cardassignment = $this->findModel($cardassignment);

        return $this->_edit($cardassignment);
    }

    public function update(Request $request, $cardassignment)
    {
        $cardassignment = $this->findModel($cardassignment);

        return $this->_update($request, $cardassignment);
    }
}
