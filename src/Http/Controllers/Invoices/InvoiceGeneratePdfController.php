<?php

namespace IlBronza\Payments\Http\Controllers\Invoices;

use IlBronza\Payments\Helpers\InvoicePdfHelper;

class InvoiceGeneratePdfController extends InvoiceCRUD
{
    public $allowedMethods = ['generatePdf'];

    public function generatePdf(string $invoice)
    {
        $invoice = $this->getModelClass()::with([
            'emitter.target',
            'target.legalDestination.address',
            'target.defaultDestination.address',
            'invoiceables.target.sellable',
            'details',
        ])->findOrFail($invoice);

        $path = InvoicePdfHelper::getOrCreateInvoicePdf($invoice);

        if (! $path) {
            abort(500, 'Impossibile generare il PDF della fattura');
        }

        return response()->file($path);
    }
}
