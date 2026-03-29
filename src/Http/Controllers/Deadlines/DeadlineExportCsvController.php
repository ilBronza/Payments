<?php

namespace IlBronza\Payments\Http\Controllers\Deadlines;

use Carbon\Carbon;
use IlBronza\Payments\Http\Controllers\Deadlines\DeadlineCRUD;
use IlBronza\Payments\Models\Deadline;
use IlBronza\Ukn\Ukn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function trans;

class DeadlineExportCsvController extends DeadlineCRUD
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
            Ukn::e(trans('payments::deadlines.noIdsProvided'));

            return back();
        }

        $deadlines = $this->getModelClass()::with([
            'invoice.emitter.target',
            'invoice.target.legalDestination.address',
            'invoice.target.defaultDestination.address',
        ])
            ->whereIn('id', $ids)
            ->get();

        $alreadyExported = $deadlines->filter(fn (Deadline $deadline) => $deadline->exported_at !== null);

        if ($alreadyExported->isNotEmpty()) {
            $names = $alreadyExported->map(fn (Deadline $d) => $d->getInvoice()?->name ?? $d->getKey())->implode(', ');

            Ukn::e(trans('payments::deadlines.alreadyExported', ['names' => $names]));

            return back();
        }

        $filename = 'export_scadenze_' . now()->format('Y-m-d_His') . '.csv';

        $array = [];

        foreach ($deadlines as $deadline) {
            $array[] = $this->deadlineToCsvRow($deadline);
        }

        $this->markDeadlinesAsExported($deadlines);

        return response()->streamDownload(function () use ($array) {
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

    protected function markDeadlinesAsExported($deadlines): void
    {
        $exportedAt = Carbon::now();
        $exportedBy = Auth::id();

        foreach ($deadlines as $deadline) {
            $deadline->exported_at = $exportedAt;
            $deadline->exported_by = $exportedBy;

            $deadline->save();

            $deadline->invoice->checkExportation();
        }
    }

    protected function deadlineToCsvRow(Deadline $deadline): array
    {
        $invoice = $deadline->getInvoice();
        $parameters = $invoice?->parameters ?? [];
        $target = $invoice?->target;
        $emitter = $invoice?->emitter;
        $destination = $target?->getLegalDestination() ?? $target?->getDefaultDestination();

        $address = $destination?->address ?? $destination?->provideAddressModelForExtraFields();

        $emitterName = $emitter?->getTarget()?->getName() ?? $emitter?->getName() ?? '';

        return [
            $parameters['causale'] ?? '48000',
            number_format((float) ($deadline->total_cost ?? 0), 2, '.', ''),
            $deadline->due_date?->format('d/m/Y') ?? '',
            $invoice?->description ?? '',
            $emitterName,
            $parameters['iban_ordinante'] ?? '',
            $target?->getName() ?? '',
            $address?->getStreet() ?? $destination?->getStreet() ?? '',
            $address?->getNumber() ?? $destination?->getNumber() ?? '',
            $address?->getCity() ?? $destination?->getCity() ?? '',
            $address?->getZip() ?? $destination?->getZip() ?? '',
            $address?->getProvince() ?? $destination?->getProvince() ?? '',
            strtoupper($address?->getState() ?? $destination?->getState() ?? 'IT'),
            $deadline->iban ?? $parameters['iban_beneficiario'] ?? $invoice?->getIban() ?? '',
            $parameters['bic_bank_code'] ?? '',
            $parameters['bic_country_code'] ?? '',
            $parameters['bic_location_code'] ?? '',
            $parameters['bic_branch_code'] ?? '',
        ];
    }
}
