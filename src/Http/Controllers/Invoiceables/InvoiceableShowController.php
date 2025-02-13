<?php

namespace IlBronza\Payments\Http\Controllers\Invoiceables;

use IlBronza\CRUD\Traits\CRUDRelationshipTrait;
use IlBronza\CRUD\Traits\CRUDShowTrait;

class InvoiceableShowController extends InvoiceableCRUD
{
    use CRUDShowTrait;
    use CRUDRelationshipTrait;

    public $allowedMethods = ['show'];

    public function getGenericParametersFile() : ? string
    {
        return config('payments.models.invoiceable.parametersFiles.show');
    }

    public function getRelationshipsManagerClass()
    {
        return config("payments.models.{$this->configModelClassName}.relationshipsManagerClasses.show");
    }

    public function show(string $invoiceable)
    {
        $invoiceable = $this->findModel($invoiceable);

        return $this->_show($invoiceable);
    }
}
