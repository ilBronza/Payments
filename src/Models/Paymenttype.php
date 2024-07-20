<?php

namespace IlBronza\Payments\Models;

use IlBronza\Payments\Models\BasePaymentsModel;
use IlBronza\Payments\Models\Paymentable;
use Illuminate\Support\Collection;

class Paymenttype extends BasePaymentsModel
{
	static $modelConfigPrefix = 'paymenttype';
	
	static $deletingRelationships = [];

	public function paymentables()
	{
		return $this->hasMany(Paymentable::getProjectClassName());
	}

	public function getRelatedPaymentableElements() : Collection
	{
		return $this->paymentables()->with('paymenttype', 'paymentable')->get();
	}
}
