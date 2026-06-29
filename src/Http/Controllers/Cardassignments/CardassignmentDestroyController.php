<?php

namespace IlBronza\Payments\Http\Controllers\Cardassignments;

use IlBronza\CRUD\Traits\CRUDDeleteTrait;

class CardassignmentDestroyController extends CardassignmentCRUD
{
    use CRUDDeleteTrait;

    public $allowedMethods = ['destroy'];

    public function destroy($cardassignment)
    {
        $cardassignment = $this->findModel($cardassignment);

        return $this->_destroy($cardassignment);
    }
}
