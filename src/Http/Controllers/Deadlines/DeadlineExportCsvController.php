<?php

namespace IlBronza\Payments\Http\Controllers\Invoices;

use Carbon\Carbon;
use IlBronza\Payments\Models\Invoice;
use IlBronza\Ukn\Ukn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function trans;

class DeadlineExportCsvController extends InvoiceCRUD
{
    public $allowedMethods = ['exportCsv'];

    protected array $csvHeaders = [
        'CAUSALE',
        'IMPORTO_RIC',
        'DATA',
        'INFORMAZIONI AL BENEFICIARIO',
        'NOME ORDINANTE',
        'IBAN_ORDINANTE',
        'NOME BENEFICIARIO',
        'VIA',
        'NR CIVICO',
        "CITTA'",
        'CAP',
        'PROVINCIA',
        'NAZIONE',
        'IBAN BENEFICIARIO',
        'BIC_BANK_CODE',
        'BIC_COUNTRY_CODE',
        'BIC_LOCATION_CODE',
        'BIC_BRANCH_CODE',
    ];

    public function exportCsv(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            Ukn::e(trans('payments::invoices.noIdsProvided'));

            return back();
        }

        $invoices = $this->getModelClass()::with([
            'target.destinations.address',
            'target.defaultDestination.address',
            'target.legalDestination.address',
            'emitter.target',
            'target.address',
        ])
            ->whereIn('id', $ids)
            ->get();

        $alreadyExported = $invoices->filter(fn (Invoice $invoice) => $invoice->exported_at !== null);

        if ($alreadyExported->isNotEmpty()) {
            $names = $alreadyExported->pluck('name')->implode(', ');

            Ukn::e(trans('payments::invoices.alreadyExported', ['names' => $names]));

            return back();
        }

        $filename = 'export_fatture_' . now()->format('Y-m-d_His') . '.csv';

        $array = [];

        foreach ($invoices as $invoice)
            $array[] = $this->invoiceToCsvRow($invoice);

        $this->markInvoicesAsExported($invoices);

        return response()->streamDownload(function () use ($invoices, $array) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF)); // UTF-8 BOM
            fputcsv($handle, $this->csvHeaders, ';');

            foreach ($array as $_array) {
                fputcsv($handle, $_array, ';');
            }

            fclose($handle);

        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    protected function markInvoicesAsExported($invoices): void
    {
        $exportedAt = Carbon::now();
        $exportedBy = Auth::id();

        foreach ($invoices as $invoice) {
            $invoice->update([
                'exported_at' => $exportedAt,
                'exported_by' => $exportedBy,
            ]);
        }
    }

    protected function invoiceToCsvRow(Invoice $invoice): array
    {
        $parameters = $invoice->parameters ?? [];
        $target = $invoice->target;
        $emitter = $invoice->emitter;
        $destination = $target?->getLegalDestination() ?? $target?->getDefaultDestination();

        $address = $destination?->address ?? $destination?->provideAddressModelForExtraFields();

        $emitterName = $emitter?->getTarget()?->getName() ?? $emitter?->getName() ?? '';

        return [
            $parameters['causale'] ?? '48000',
            number_format((float) ($invoice->amount ?? 0), 2, '.', ''),
            $invoice->date?->format('d/m/Y') ?? '',
            $invoice->description ?? '',
            $emitterName,
            $parameters['iban_ordinante'] ?? '',
            $target?->getName() ?? '',
            $address?->getStreet() ?? $destination?->getStreet() ?? '',
            $address?->getNumber() ?? $destination?->getNumber() ?? '',
            $address?->getCity() ?? $destination?->getCity() ?? '',
            $address?->getZip() ?? $destination?->getZip() ?? '',
            $address?->getProvince() ?? $destination?->getProvince() ?? '',
            strtoupper($address?->getState() ?? $destination?->getState() ?? 'IT'),
            $parameters['iban_beneficiario'] ?? '',
            $parameters['bic_bank_code'] ?? '',
            $parameters['bic_country_code'] ?? '',
            $parameters['bic_location_code'] ?? '',
            $parameters['bic_branch_code'] ?? '',
        ];
    }
}
