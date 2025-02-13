<?php

namespace IlBronza\Payments\Http\Controllers\Invoices;

use IlBronza\CRUD\Traits\CRUDEditUpdateTrait;
use Illuminate\Http\Request;

class InvoiceEditUpdateController extends InvoiceCRUD
{
    use CRUDEditUpdateTrait;

    public $allowedMethods = ['edit', 'update'];

    public function getGenericParametersFile() : ? string
    {
        return config('payments.models.invoice.parametersFiles.edit');
    }

    public function edit(string $invoice)
    {
        $invoice = $this->findModel($invoice);

        return $this->_edit($invoice);
    }

    public function update(Request $request, $invoice)
    {
        $invoice = $this->findModel($invoice);

        return $this->_update($request, $invoice);
    }
}
