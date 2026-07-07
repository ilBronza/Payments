<?php

namespace IlBronza\Payments\Http\Controllers\Bankaccounts;

use IlBronza\CRUD\Traits\CRUDCreateStoreTrait;

class BankaccountCreateStoreController extends BankaccountCRUD
{
    use CRUDCreateStoreTrait;

    public $allowedMethods = ['create', 'store'];

    public function getGenericParametersFile(): ?string
    {
        return config('payments.models.bankaccount.parametersFiles.create');
    }
}
