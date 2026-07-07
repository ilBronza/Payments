<?php

namespace IlBronza\Payments\Http\Controllers\Bankaccounts;

use IlBronza\Payments\Http\Controllers\CRUDPaymentsPackageController;

class BankaccountCRUD extends CRUDPaymentsPackageController
{
    public $configModelClassName = 'bankaccount';
}
