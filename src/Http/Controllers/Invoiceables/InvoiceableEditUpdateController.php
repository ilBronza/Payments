<?php

namespace IlBronza\Payments\Http\Controllers\Invoiceables;

use IlBronza\CRUD\Traits\CRUDEditUpdateTrait;
use Illuminate\Http\Request;

class InvoiceableEditUpdateController extends InvoiceableCRUD
{
    use CRUDEditUpdateTrait;

    public $allowedMethods = ['edit', 'update'];

    public function getGenericParametersFile() : ? string
    {
        return config('payments.models.invoiceable.parametersFiles.create');
    }

    public function edit(string $invoiceable)
    {
        $invoiceable = $this->findModel($invoiceable);

        return $this->_edit($invoiceable);
    }

    public function update(Request $request, $invoiceable)
    {
        $invoiceable = $this->findModel($invoiceable);

        return $this->_update($request, $invoiceable);
    }
}
