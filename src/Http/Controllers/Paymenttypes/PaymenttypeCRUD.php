<?php

namespace IlBronza\Payments\Http\Controllers\Paymenttypes;

use IlBronza\Payments\Http\Controllers\CRUDPaymentsPackageController;

class PaymenttypeCRUD extends CRUDPaymentsPackageController
{
    public $configModelClassName = 'paymenttype';
}
