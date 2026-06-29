<?php

namespace IlBronza\Payments\Http\Controllers\Cardtypes;

use IlBronza\CRUD\Traits\CRUDDeleteTrait;

class CardtypeDestroyController extends CardtypeCRUD
{
    use CRUDDeleteTrait;

    public $allowedMethods = ['destroy'];

    public function destroy($cardtype)
    {
        $cardtype = $this->findModel($cardtype);

        return $this->_destroy($cardtype);
    }
}
