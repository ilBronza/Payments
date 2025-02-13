<?php

namespace IlBronza\Payments\Models\Traits;

use IlBronza\Payments\Models\Invoice;
use IlBronza\Payments\Models\Invoiceable;
use Illuminate\Database\Eloquent\Relations\MorphToMany;


trait InteractsWithInvoiceables
{
	public function invoices() : MorphToMany
	{
		return $this->morphToMany(
			Invoice::gpc(),
			'target',
			config('payments.models.invoiceable.table')
		)->using(Invoiceable::gpc())->withTimestamps();
	}
}