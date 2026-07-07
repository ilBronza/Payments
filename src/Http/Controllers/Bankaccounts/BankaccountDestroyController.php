<?php

namespace IlBronza\Payments\Http\Controllers\Bankaccounts;

use IlBronza\CRUD\Traits\CRUDDeleteTrait;

class BankaccountDestroyController extends BankaccountCRUD
{
    use CRUDDeleteTrait;

    public $allowedMethods = ['destroy'];

    public function destroy($bankaccount)
    {
        $bankaccount = $this->findModel($bankaccount);

        return $this->_destroy($bankaccount);
    }
}
