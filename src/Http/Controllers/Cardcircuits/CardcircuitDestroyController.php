<?php

namespace IlBronza\Payments\Http\Controllers\Cardcircuits;

use IlBronza\CRUD\Traits\CRUDDeleteTrait;

class CardcircuitDestroyController extends CardcircuitCRUD
{
    use CRUDDeleteTrait;

    public $allowedMethods = ['destroy'];

    public function destroy($cardcircuit)
    {
        $cardcircuit = $this->findModel($cardcircuit);

        return $this->_destroy($cardcircuit);
    }
}
