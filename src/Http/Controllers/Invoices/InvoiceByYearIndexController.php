<?php

namespace IlBronza\Payments\Http\Controllers\Invoices;

use IlBronza\CRUD\Traits\CRUDIndexTrait;
use IlBronza\CRUD\Traits\CRUDPlainIndexTrait;

use function config;

class InvoiceByYearIndexController extends InvoiceIndexController
{
    public function getIndexElements()
    {
        return $this->getModelClass()::with([
			'target',
	        'emitter.target',
            'invoiceables.target',
            'orderrows.extraFields'
        ])->byYear(request()->year)
        ->whereHas('emitter', function($query)
        {
            $query->where('target_id', 'fcb95686-1abe-4a14-bd2d-36ffbf580be9');
        })
            // ->where('id', 'a151652f-b5f4-4b66-acf3-b20d6c776e4d')
            // ->take(100)
            ->get();
    }

}
