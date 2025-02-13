<?php

namespace IlBronza\Payments\Http\Controllers\Invoices;

use IlBronza\CRUD\Traits\CRUDRelationshipTrait;
use IlBronza\CRUD\Traits\CRUDShowTrait;

use function config;

class InvoiceShowController extends InvoiceCRUD
{
    use CRUDShowTrait;
    use CRUDRelationshipTrait;

    public $allowedMethods = ['show'];

    public function getGenericParametersFile() : ? string
    {
        return config('payments.models.invoice.parametersFiles.show');
    }

    public function getRelationshipsManagerClass()
    {
        return config("payments.models.{$this->configModelClassName}.relationshipsManagerClasses.show");
    }

    public function show(string $invoice)
    {
        $invoice = $this->findModel($invoice);

        return $this->_show($invoice);
    }
}
