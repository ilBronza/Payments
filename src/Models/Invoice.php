<?php

namespace IlBronza\Payments\Models;

use Carbon\Carbon;
use IlBronza\Clients\Models\Client;
use IlBronza\CRUD\Traits\Model\CRUDUseUuidTrait;

use IlBronza\FileCabinet\Traits\InteractsWithFormTrait;
use IlBronza\Products\Models\Orders\Orderrow;
use IlBronza\Products\Models\Quotations\Quotationrow;

use IlBronza\Products\Models\Sellables\Supplier;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Invoice extends BasePaymentsModel
{
	use InteractsWithFormTrait;
	use CRUDUseUuidTrait;

	protected $keyType = 'string';

	static $modelConfigPrefix = 'invoice';
	
	static $deletingRelationships = [];

	public $casts = [
		'date' => 'date',
		'deleted_at' => 'date',
		'parameters' => 'json'
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
}
