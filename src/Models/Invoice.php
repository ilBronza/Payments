<?php

namespace IlBronza\Payments\Models;

use IlBronza\CRUD\Traits\Model\CRUDUseUuidTrait;
use IlBronza\Payments\Models\BasePaymentsModel;

class Invoice extends BasePaymentsModel
{
	use CRUDUseUuidTrait;

	protected $keyType = 'string';

	static $modelConfigPrefix = 'invoice';
	
	static $deletingRelationships = [];

	public $casts = [
		'data' => 'date',
		'deleted_at' => 'date',
		'parameters' => 'json'
	];

	public function emitter()
	{
		return $this->morphTo();
	}
}
