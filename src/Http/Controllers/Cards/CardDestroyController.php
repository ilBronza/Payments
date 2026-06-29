<?php

namespace IlBronza\Payments\Http\Controllers\Cards;

use IlBronza\CRUD\Traits\CRUDDeleteTrait;

class CardDestroyController extends CardCRUD
{
    use CRUDDeleteTrait;

    public $allowedMethods = ['destroy'];

    public function destroy($card)
    {
        $card = $this->findModel($card);

        return $this->_destroy($card);
    }
}
