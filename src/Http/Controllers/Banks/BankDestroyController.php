<?php

namespace IlBronza\Payments\Http\Controllers\Banks;

use IlBronza\CRUD\Traits\CRUDDeleteTrait;

class BankDestroyController extends BankCRUD
{
    use CRUDDeleteTrait;

    public $allowedMethods = ['destroy'];

    public function destroy($bank)
    {
        $bank = $this->findModel($bank);

        return $this->_destroy($bank);
    }
}
