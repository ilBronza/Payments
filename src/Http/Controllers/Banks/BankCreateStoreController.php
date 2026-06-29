<?php

namespace IlBronza\Payments\Http\Controllers\Banks;

use IlBronza\CRUD\Traits\CRUDCreateStoreTrait;

class BankCreateStoreController extends BankCRUD
{
    use CRUDCreateStoreTrait;

    public $allowedMethods = ['create', 'store'];

    public function getGenericParametersFile(): ?string
    {
        return config('payments.models.bank.parametersFiles.create');
    }
}
