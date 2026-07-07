<?php

namespace IlBronza\Payments\Http\Controllers\Bankaccounts;

use IlBronza\CRUD\Traits\CRUDEditUpdateTrait;
use Illuminate\Http\Request;

class BankaccountEditUpdateController extends BankaccountCRUD
{
    use CRUDEditUpdateTrait;

    public $allowedMethods = ['edit', 'update'];

    public function getGenericParametersFile(): ?string
    {
        return config('payments.models.bankaccount.parametersFiles.edit');
    }

    public function edit(string $bankaccount)
    {
        $bankaccount = $this->findModel($bankaccount);

        return $this->_edit($bankaccount);
    }

    public function update(Request $request, $bankaccount)
    {
        $bankaccount = $this->findModel($bankaccount);

        return $this->_update($request, $bankaccount);
    }
}
