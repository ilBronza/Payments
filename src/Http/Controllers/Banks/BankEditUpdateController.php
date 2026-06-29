<?php

namespace IlBronza\Payments\Http\Controllers\Banks;

use IlBronza\CRUD\Traits\CRUDEditUpdateTrait;
use Illuminate\Http\Request;

class BankEditUpdateController extends BankCRUD
{
    use CRUDEditUpdateTrait;

    public $allowedMethods = ['edit', 'update'];

    public function getGenericParametersFile(): ?string
    {
        return config('payments.models.bank.parametersFiles.edit');
    }

    public function edit(string $bank)
    {
        $bank = $this->findModel($bank);

        return $this->_edit($bank);
    }

    public function update(Request $request, $bank)
    {
        $bank = $this->findModel($bank);

        return $this->_update($request, $bank);
    }
}
