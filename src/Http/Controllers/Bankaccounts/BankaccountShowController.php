<?php

namespace IlBronza\Payments\Http\Controllers\Bankaccounts;

use IlBronza\CRUD\Traits\CRUDRelationshipTrait;
use IlBronza\CRUD\Traits\CRUDShowTrait;

class BankaccountShowController extends BankaccountCRUD
{
    use CRUDShowTrait;
    use CRUDRelationshipTrait;

    public $allowedMethods = ['show'];

    public function getGenericParametersFile(): ?string
    {
        return config('payments.models.bankaccount.parametersFiles.show');
    }

    public function show(string $bankaccount)
    {
        $bankaccount = $this->findModel($bankaccount);

        return $this->_show($bankaccount);
    }
}
