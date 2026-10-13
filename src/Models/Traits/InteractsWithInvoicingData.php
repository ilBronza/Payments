<?php

namespace IlBronza\Payments\Models\Traits;

use IlBronza\Payments\Models\InvoicingData;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait InteractsWithInvoicingData
{
    public function invoicingData(): MorphOne
    {
        return $this->morphOne(InvoicingData::gpc(), 'invoicing_dataable');
    }
}
