<?php

namespace IlBronza\Payments\Http\Controllers\Banks;

use IlBronza\CRUD\Traits\CRUDShowTrait;

class BankShowController extends BankCRUD
{
    use CRUDShowTrait;

    public $allowedMethods = ['show'];

    public function getGenericParametersFile(): ?string
    {
        return config('payments.models.bank.parametersFiles.show');
    }

    public function show(string $bank)
    {
        $bank = $this->findModel($bank);

        return $this->_show($bank);
    }
}
