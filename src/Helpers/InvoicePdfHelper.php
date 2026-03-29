<?php

namespace IlBronza\Payments\Helpers;

use Barryvdh\DomPDF\Facade\Pdf;
use IlBronza\Payments\Models\Invoice;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Recupera o genera il PDF della fattura.
 * Se esiste un file con il filename corretto sul disco paymentsInvoices, restituisce il path.
 * Altrimenti genera il PDF (da attachment o dalla view), lo salva e restituisce il path.
 */
class InvoicePdfHelper
{
	public static function getInvoiceFilename(Invoice $invoice): string
	{
		$vat = $invoice->getCompanyVat();
		$partitaIva = preg_replace('/[^a-zA-Z0-9]/', '', $vat) ?: 'nopiva';

		$nome = Str::slug($invoice->getNumber() ?? $invoice->getKey(), '-');
		$data = $invoice->getDate()?->format('Y-m-d') ?? 'nodata';
		$id = $invoice->getKey();

		return "{$partitaIva}_{$nome}_{$data}_{$id}.pdf";
	}

	/**
	 * Restituisce il path del PDF. Se esiste già lo restituisce, altrimenti lo crea e lo salva.
	 * Blocca con eccezione se la fattura non ha scadenze (deadlines).
	 */
	public static function getOrCreateInvoicePdf(Invoice $invoice): ?string
	{
		$filename = static::getInvoiceFilename($invoice);
		$disk = Storage::disk('paymentsInvoices');

		if ($disk->exists($filename)) {
			return static::getDiskPath($filename);
		}

		$deadlines = $invoice->deadlines ?? $invoice->deadlines()->get();
		if ($deadlines->isEmpty()) {
			throw new \RuntimeException('Impossibile generare il PDF: la fattura non ha scadenze (deadlines).');
		}

		return static::saveInvoicePdf($invoice);
	}

	protected static function getDiskPath(string $filename): string
	{
		$root = config('filesystems.disks.paymentsInvoices.root', storage_path('app/payments/invoices'));

		return rtrim($root, '/') . '/' . $filename;
	}

	public static function saveInvoicePdf(Invoice $invoice): ?string
	{
		$content = static::getInvoicePdfContent($invoice);

		if ($content === null) {
			return null;
		}

		$filename = static::getInvoiceFilename($invoice);
		$directory = config('filesystems.disks.paymentsInvoices.root', storage_path('app/payments/invoices'));

		File::ensureDirectoryExists($directory);

		$written = @file_put_contents($directory . '/' . $filename, $content);

		if ($written === false) {
			$error = error_get_last();
			throw new \RuntimeException(
				'Salvataggio PDF fattura fallito. Path: ' . $directory . '/' . $filename . '. '
				. 'Errore: ' . ($error['message'] ?? 'sconosciuto')
			);
		}

		return $directory . '/' . $filename;
	}

	protected static function getInvoicePdfContent(Invoice $invoice): ?string
	{
		$content = static::getAttachmentPdfContent($invoice);

		if ($content !== null) {
			return $content;
		}

		return static::generateInvoicePdfContent($invoice);
	}

	protected static function getAttachmentPdfContent(Invoice $invoice): ?string
	{
		$attachment = $invoice->attachment ?? null;

		if (empty($attachment)) {
			return null;
		}

		$content = is_string($attachment)
			? (base64_decode($attachment, true) ?: $attachment)
			: null;

		if ($content !== null && str_starts_with($content, '%PDF')) {
			return $content;
		}

		return null;
	}

	protected static function generateInvoicePdfContent(Invoice $invoice): string
	{
		$invoice->load([
			'emitter.target',
			'target.legalDestination.address',
			'target.defaultDestination.address',
			'invoiceables.target.sellable',
			'details',
		]);

		$pdf = Pdf::loadView('payments::invoices.pdf', [
			'invoice' => $invoice,
		]);

		$pdf->set_option('isRemoteEnabled', true);
		$pdf->setPaper('a4', 'portrait');

		return $pdf->output();
	}
}
