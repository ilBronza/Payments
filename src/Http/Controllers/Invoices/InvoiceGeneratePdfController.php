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
            'details',
        ])->findOrFail($invoice);

        $filename = 'fattura_' . ($invoice->name ?? $invoice->getKey()) . '.pdf';

        if (!empty($invoice->attachment)) {
            $content = base64_decode($invoice->attachment, true) ?: $invoice->attachment;

            if (str_starts_with($content, '%PDF')) {
                return response($content, 200, [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'inline; filename="' . $filename . '"',
                ]);
            }
        }

        $pdf = Pdf::loadView('payments::invoices.pdf', [
            'invoice' => $invoice,
        ]);

        $pdf->set_option('isRemoteEnabled', true);
        $pdf->setPaper('a4', 'portrait');

        return $pdf->stream($filename);
    }
}
