<?php

namespace IlBronza\Payments\Http\Controllers\Invoiceables;

use IlBronza\Payments\Http\Controllers\CRUDPaymentsPackageController;

class InvoiceableCRUD extends CRUDPaymentsPackageController
{
    public $configModelClassName = 'invoiceable';
}
