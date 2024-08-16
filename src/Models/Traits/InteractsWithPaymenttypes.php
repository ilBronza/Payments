<?php

namespace IlBronza\Payments\Models\Traits;

use IlBronza\Payments\Models\Paymenttype;
use Illuminate\Database\Eloquent\Relations\MorphToMany;


trait InteractsWithPaymenttypes 
{
	public function paymenttypes() : MorphToMany
	{
		return $this->morphToMany(
			Paymenttype::getProjectClassName(),
			'paymentable',
			config('payments.models.paymentable.table')
		);
	}

	public function getPossiblePaymenttypesValuesArray() : array
	{
		return Paymenttype::getProjectClassName()::all()->pluck('name', 'id')->toArray();
	}
}