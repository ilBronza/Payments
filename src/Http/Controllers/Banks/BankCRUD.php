<?php

namespace IlBronza\Payments\Http\Controllers\Banks;

use IlBronza\Payments\Http\Controllers\CRUDPaymentsPackageController;

class BankCRUD extends CRUDPaymentsPackageController
{
    public $configModelClassName = 'bank';
}
