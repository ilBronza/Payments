<?php

namespace IlBronza\Payments\Http\Controllers\Invoices;

use Barryvdh\DomPDF\Facade\Pdf;

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
        ])->findOrFail($invoice);

        // return view('payments::invoices.pdf', ['invoice' => $invoice]);

        $pdf = Pdf::loadView('payments::invoices.pdf', [
            'invoice' => $invoice,
        ]);

        $pdf->set_option('isRemoteEnabled', true);
        $pdf->setPaper('a4', 'portrait');

        $filename = 'fattura_' . ($invoice->name ?? $invoice->getKey()) . '.pdf';

        return $pdf->stream($filename);
    }
}
