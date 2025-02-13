<?php

namespace IlBronza\Payments\Http\Controllers\Invoiceables;

use IlBronza\CRUD\Traits\CRUDDeleteTrait;

class InvoiceableDestroyController extends InvoiceableCRUD
{
    use CRUDDeleteTrait;

    public $allowedMethods = ['destroy'];

    public function destroy($invoiceable)
    {
        $invoiceable = $this->findModel($invoiceable);

        return $this->_destroy($invoiceable);
    }
}