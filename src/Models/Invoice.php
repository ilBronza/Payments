<?php

namespace IlBronza\Payments\Models;

use Auth;
use Carbon\Carbon;
use IlBronza\CRUD\Traits\Model\CRUDUseUuidTrait;
use IlBronza\Clients\Models\Client;
use IlBronza\FileCabinet\Traits\InteractsWithFormTrait;
use IlBronza\Payments\Models\Deadline;
use IlBronza\Payments\Models\InvoiceDetail;
use IlBronza\Products\Models\Orders\Orderrow;
use IlBronza\Products\Models\Quotations\Quotationrow;
use IlBronza\Products\Models\Sellables\Supplier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Collection;

class Invoice extends BasePaymentsModel
{
	use InteractsWithFormTrait;
	use CRUDUseUuidTrait;

	protected $keyType = 'string';

	static $modelConfigPrefix = 'invoice';
	
	static $deletingRelationships = ['deadlines', 'details'];

	public $fillable = [
		'exported_at',
		'exported_by'
	];

	public $casts = [
		'date' => 'date',
		'deleted_at' => 'date',
		'parameters' => 'json',
		'confirmed' => 'boolean',
		'approved' => 'boolean',
		'sent_payment' => 'boolean',
		'payment_confirmed' => 'boolean',
		'exported_at' => 'datetime',
	];

	public function emitter()
	{
		return $this->belongsTo(Supplier::gpc());
	}

	public function getEmitter() : ? Supplier
	{
		return $this->emitter;
	}

	public function target()
	{
		return $this->belongsTo(Client::gpc());
	}

	public function invoiceables()
	{
		return $this->hasMany(
			Invoiceable::gpc()
		)->with('target');
	}

	public function deadlines()
	{
		return $this->hasMany(Deadline::gpc());
	}

	public function details()
	{
		return $this->hasMany(InvoiceDetail::gpc())->orderBy('sorting_index');
	}

	public function getRelatedDeadlineElements(): Collection
	{
		return $this->deadlines()->with('invoice.emitter')->get();
	}

	public function getRelatedInvoiceableElements(): Collection
	{
		return $this->invoiceables()->with('invoice')->get();
	}

	public function quotationrows(): MorphToMany
	{
		return $this->morphedByMany(
			Quotationrow::gpc(),
			'target',
			config('payments.models.invoiceable.table')
		)->using(Invoiceable::gpc())->withTimestamps();
	}

	public function orderrows()
	{
		return $this->morphedByMany(
			Orderrow::gpc(),
			'target',
			config('payments.models.invoiceable.table')
		)->using(Invoiceable::gpc())->withTimestamps();
	}

	public function setDate($date)
	{
		$this->date = $date;
	}


	public function getDate() : ? Carbon
	{
		return $this->date;
	}

	public function attachDetail($model)
	{
		$relation = $model->getPluralCamelcaseClassBasename();

		return $this->$relation()->attach($model->getKey());
	}

	public function scopeByEmitter($query, $emitter)
	{
		$query->where('emitter_id', $emitter->getKey());
	}

	public function scopeByYear($query, $year)
	{
		$query->whereBetween('date', [
			"{$year}-01-01 00:00:00",
			"{$year}-12-31 23:59:59",
		]);
	}

	public function getGeneratePdfUrl() : string
	{
		return $this->getKeyedRoute('generatePdf');
	}

	public function getYear() : ? int
	{
		return $this->getDate()?->year;
	}













protected function getEmitterTarget(): ?Model
{
	return $this->getEmitter()?->getTarget();
}

protected function getEmitterClient(): ?Client
{
	$target = $this->getEmitterTarget();

	return $target instanceof Client ? $target : null;
}

protected function getCompanyAddressFromClient(Client $client): string
{
	$street = $client->street . " " . $client->number;

	$city = $client->city;
	$zip = $client->zip;
	$province = $client->province;

	$parts = array_filter([$street, trim("{$zip} {$city} {$province}")]);

	return implode(', ', $parts);
}

protected function getCompanyAddressFromOperator($operator): string
{
	$address = $operator->address ?? $operator->address()->first();

	if (!$address) {
		return '';
	}

	$street = $address->getStreetString();
	$city = $address->getCityString();
	$zip = $address->getZip();

	$parts = array_filter([$street, trim("{$zip} {$city}")]);

	return implode(', ', $parts);
}

public function getCompanyName(): string
{
	$target = $this->getEmitterTarget();

	if ($target instanceof Client) {
		return $target->fiscal_name ?: $target->name ?? '';
	}

	if ($target && method_exists($target, 'getName')) {
		return $target->getName() ?? '';
	}

	return config('payments.invoice.defaults.company_name', '');
}

public function getCompanyAddress(): string
{
	$client = $this->getEmitterClient();

	if ($client) {
		return $this->getCompanyAddressFromClient($client);
	}

	$target = $this->getEmitterTarget();

	if ($target && method_exists($target, 'address')) {
		return $this->getCompanyAddressFromOperator($target);
	}

	return '';
}

public function getCompanyVat(): string
{
	$client = $this->getEmitterClient();

	return $client?->vat ? ('IT' . str_pad($client->vat, 11, '0', STR_PAD_LEFT)) : '';
}

public function getCompanyFiscalCode(): string
{
	$target = $this->getEmitterTarget();

	return $target?->fiscal_code ?? '';
}

public function getFiscalRegime(): string
{
	$params = $this->parameters ?? [];

	return $params['fiscal_regime'] ?? config('payments.invoice.defaults.fiscal_regime', 'RF19 (Regime forfettario)');
}

public function getCustomerName(): string
{
	$target = $this->target;

	return $target?->fiscal_name ?: $target?->name ?? '';
}

public function getCustomerAddress(): string
{
	$target = $this->target;

	if (!$target) {
		return '';
	}

	$destination = $target->getLegalDestination() ?? $target->getDefaultDestination();

	if (!$destination) {
		return '';
	}

	$address = $destination->getAddress() ?? $destination->provideAddressModelForExtraFields();
	$street = $destination->getStreetAddress() ?? $address?->getStreetString() ?? '';
	$city = $address?->getCity() ?? $destination->getCity() ?? '';
	$zip = $address?->getZip() ?? '';
	$province = $address?->getProvince() ?? $destination->getProvince() ?? '';

	$parts = array_filter([$street, trim("{$zip} {$city} {$province}")]);

	return implode(', ', $parts);
}

public function getCustomerVat(): string
{
	$target = $this->target;

	return $target?->vat ? ('IT' . str_pad($target->vat, 11, '0', STR_PAD_LEFT)) : '';
}

public function getCustomerFiscalCode(): string
{
	$target = $this->target;

	return $target?->fiscal_code ?? $target?->vat ?? '';
}

public function getDocumentType(): string
{
	$params = $this->parameters ?? [];

	return $params['document_type'] ?? config('payments.invoice.defaults.document_type', 'TD01 (fattura)');
}

public function getNumber(): string
{
	return $this->name ?? (string) $this->getKey();
}

public function getDateFormatted(): string
{
	$date = $this->getDate();

	return $date ? $date->locale('it')->isoFormat('D MMMM YYYY') : '';
}

public function getCurrency(): string
{
	$params = $this->parameters ?? [];

	return $params['currency'] ?? config('payments.invoice.defaults.currency', 'EUR');
}

public function getReason(): string
{
	$params = $this->parameters ?? [];

	return $params['causale'] ?? $this->description ?? config('payments.invoice.defaults.fiscal_operation_description', '');
}

public function getStampDutyLabel(): string
{
	$params = $this->parameters ?? [];

	return ($params['bollo_virtuale'] ?? true) ? 'SI' : 'NO';
}

public function getStampDutyFormatted(): string
{
	$params = $this->parameters ?? [];
	$amount = $params['importo_bollo'] ?? 0;

	return number_format((float) $amount, 2, ',', '.');
}

public function getHasSocialSecurity(): bool
{
	$params = $this->parameters ?? [];
	$cassa = $params['cassa_previdenziale'] ?? null;

	return is_array($cassa) && !empty($cassa);
}

public function getSocialSecurityType(): string
{
	$params = $this->parameters ?? [];
	$cassa = $params['cassa_previdenziale'] ?? [];

	return is_array($cassa) ? ($cassa['tipo'] ?? 'TC22 (INPS)') : 'TC22 (INPS)';
}

public function getSocialSecurityRateFormatted(): string
{
	$params = $this->parameters ?? [];
	$cassa = $params['cassa_previdenziale'] ?? [];
	$rate = is_array($cassa) ? ($cassa['aliquota'] ?? 0) : 0;

	return number_format((float) $rate, 2, ',', '.');
}

public function getSocialSecurityAmountFormatted(): string
{
	$params = $this->parameters ?? [];
	$cassa = $params['cassa_previdenziale'] ?? [];
	$amount = is_array($cassa) ? ($cassa['importo'] ?? 0) : 0;

	return number_format((float) $amount, 2, ',', '.');
}

public function getSocialSecurityVatRateFormatted(): string
{
	$params = $this->parameters ?? [];
	$cassa = $params['cassa_previdenziale'] ?? [];
	$rate = is_array($cassa) ? ($cassa['aliquota_iva'] ?? 0) : 0;

	return number_format((float) $rate, 2, ',', '.');
}

public function getSocialSecurityExemptionCode(): string
{
	$params = $this->parameters ?? [];
	$cassa = $params['cassa_previdenziale'] ?? [];

	return is_array($cassa) ? ($cassa['esenzione'] ?? 'N2.2') : 'N2.2';
}

public function getDetails(): Collection
{
	$defaultUm = config('payments.invoice.defaults.default_unit_of_measure', 'NR');
	$defaultVat = config('payments.invoice.defaults.vat_exigibility_code', 'N2.2');

	if ($this->details->isNotEmpty()) {
		return $this->details->map(fn (InvoiceDetail $detail) => [
			$detail->description ?? '',
			$defaultUm,
			(float) ($detail->quantity ?? 1),
			(float) ($detail->unit_price ?? 0),
			$detail->vat_rate !== null ? number_format((float) $detail->vat_rate, 2, ',', '.') : $defaultVat,
		])->values();
	}

	$invoiceables = $this->invoiceables()->with('target')->get();
	$details = collect();

	foreach ($invoiceables as $invoiceable) {
		$target = $invoiceable->getTarget();

		if (!$target) {
			continue;
		}

		$description = method_exists($target, 'getInvoiceableDetail') ? $target->getInvoiceableDetail() : '';
		$quantity = method_exists($target, 'getQuantity') ? (float) $target->getQuantity() : 1;

		$unitPrice = 0;

		if (property_exists($target, 'client_price') && $target->client_price !== null) {
			$unitPrice = (float) $target->client_price;
		} elseif (isset($target->calculated_cost_company)) {
			$unitPrice = (float) $target->calculated_cost_company;
		} elseif (isset($target->cost_company)) {
			$unitPrice = (float) $target->cost_company;
		} elseif ($quantity > 0 && $this->amount) {
			$totalRows = $invoiceables->count();
			$unitPrice = $totalRows > 0 ? (float) $this->amount / $totalRows / $quantity : 0;
		}

		$um = $defaultUm;

		if (isset($target->sellable) && $target->sellable) {
			$type = $target->sellable->type ?? null;
			$um = match ($type) {
				'operator' => 'GIORNI',
				'vehicle' => 'KM',
				default => $defaultUm,
			};
		}

		$details->push([
			$description,
			$um,
			$quantity,
			$unitPrice,
			$defaultVat,
		]);
	}

	if ($details->isEmpty() && $this->amount) {
		$details->push([
			$this->description ?? 'Servizi',
			$defaultUm,
			1,
			(float) $this->amount,
			$defaultVat,
		]);
	}

	return $details;
}

public function getVatExigibilityCode(): string
{
	$params = $this->parameters ?? [];

	return $params['esigibilita_iva'] ?? config('payments.invoice.defaults.vat_exigibility_code', 'N2.2');
}

public function getVatRateFormatted(): string
{
	return number_format((float) ($this->vat ?? 0), 2, ',', '.');
}

public function getVatTotalFormatted(): string
{
	return number_format((float) ($this->vat ?? 0), 2, ',', '.');
}

public function getTaxableTotalFormatted(): string
{
	$amount = (float) ($this->amount ?? 0);
	$vatAmount = (float) ($this->vat ?? 0);

	return number_format($amount - $vatAmount, 2, ',', '.');
}

public function getGrandTotalFormatted(): string
{
	return number_format((float) ($this->amount ?? 0), 2, ',', '.');
}

public function getPaymentMethod(): string
{
	$params = $this->parameters ?? [];

	return $params['metodo_pagamento'] ?? config('payments.invoice.defaults.payment_method', 'MP05 (bonifico)');
}

public function getBankName(): string
{
	$params = $this->parameters ?? [];

	return $params['istituto_finanziario'] ?? '';
}

public function getIban(): string
{
	$params = $this->parameters ?? [];

	return $params['iban_beneficiario'] ?? $params['iban'] ?? '';
}

public function getFiscalOperationDescription(): ?string
{
	$params = $this->parameters ?? [];

	return $params['descrizione_operazione_fiscale'] ?? config('payments.invoice.defaults.fiscal_operation_description');
}

public function getRecipientAdministrativeCode(): ?string
{
	return $this->target?->sdi ?? null;
}

public function getPaymentDueDateFormatted(): ?string
{
	$params = $this->parameters ?? [];
	$date = $params['scadenza_pagamento'] ?? null;

	if (!$date) {
		return null;
	}

	try {
		return Carbon::parse($date)->locale('it')->isoFormat('D MMMM YYYY');
	} catch (\Throwable $e) {
		return null;
	}
}

public function getNameDateString() : string
{
	if(! $this->date)
		return $this->name;

	return "{$this->date->format('d-m-Y')} - {$this->name}";
}

public function checkExportation()
{
	if(! $this->deadlines)
		return ;

	foreach($this->deadlines as $deadline)
		if(! $deadline->hasBeenExported())
			return;

	$this->marAsExported();
}

public function marAsExported()
{
    $this->exported_at = Carbon::now();
    $this->exported_by = Auth::id();

    $this->save();	
}
}
