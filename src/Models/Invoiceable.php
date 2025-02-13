<?php

namespace IlBronza\Payments\Models;

use IlBronza\CRUD\Traits\Model\CRUDModelRoutingTrait;
use IlBronza\CRUD\Traits\Model\CRUDModelTrait;
use IlBronza\CRUD\Traits\Model\CRUDUseUuidTrait;
use IlBronza\CRUD\Traits\Model\PackagedModelsTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphPivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoiceable extends MorphPivot
{
	use CRUDModelTrait;
	use PackagedModelsTrait;
	use CRUDModelRoutingTrait;
	use CRUDUseUuidTrait;
	use SoftDeletes;

	use PackagedModelsTrait {
		PackagedModelsTrait::getRouteBaseNamePrefix insteadof CRUDModelRoutingTrait;
		PackagedModelsTrait::getRouteBaseNamePrefix insteadof CRUDModelTrait;
		PackagedModelsTrait::getPluralTranslatedClassname insteadof CRUDModelTrait;
		PackagedModelsTrait::getTranslatedClassname insteadof CRUDModelTrait;
	}

	static $packageConfigPrefix = 'payments';
	static $modelConfigPrefix = 'invoiceable';

	public $deletingRelationships = [];
	protected $keyType = 'string';

	public function invoice()
	{
		return $this->belongsTo(
			Invoice::gpc()
		);
	}

	public function target()
	{
		return $this->morphTo();
	}

	public function getTarget() : ? Model
	{
		return $this->target;
	}

	public function getName()
	{
		return $this->getNameForDisplayRelation();
	}

	public function getNameForDisplayRelation()
	{
		return $this->getTarget()->getInvoiceableDetail();
	}
}