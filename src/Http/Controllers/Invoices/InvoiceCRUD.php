<?php

namespace IlBronza\Payments\Http\Controllers\Invoices;

use IlBronza\Payments\Http\Controllers\CRUDPaymentsPackageController;

class InvoiceCRUD extends CRUDPaymentsPackageController
{
    public $configModelClassName = 'invoice';
}
