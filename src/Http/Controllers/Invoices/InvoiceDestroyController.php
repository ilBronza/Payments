<?php

namespace IlBronza\Payments\Http\Controllers\Invoices;

use IlBronza\CRUD\Traits\CRUDDeleteTrait;

class InvoiceDestroyController extends InvoiceCRUD
{
    use CRUDDeleteTrait;

    public $allowedMethods = ['destroy'];

    public function destroy($invoice)
    {
        $invoice = $this->findModel($invoice);

        return $this->_destroy($invoice);
    }
}