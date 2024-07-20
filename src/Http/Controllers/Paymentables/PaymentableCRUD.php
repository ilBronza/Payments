<?php

namespace IlBronza\Payments\Http\Controllers\Paymentables;

use IlBronza\Payments\Http\Controllers\CRUDPaymentsPackageController;

class PaymentableCRUD extends CRUDPaymentsPackageController
{
    public $configModelClassName = 'paymentable';
}
