<?php

namespace IlBronza\Payments\Http\Controllers\Invoices;

use Carbon\Carbon;
use IlBronza\CRUD\Traits\CRUDIndexTrait;
use IlBronza\CRUD\Traits\CRUDPlainIndexTrait;
use function config;

class InvoiceByYearIndexController extends InvoiceIndexController
{
    public $rowSelectCheckboxes = true;

    public function getIndexElements()
    {
        return $this->getModelClass()::with([
			'target',
            'deadlines',
	        'emitter.target.extraFields',
            'invoiceables.target',
            'orderrows.extraFields',
            'orderrows.sellable',
            'orderrows.sellableSupplier.supplier.target',
            'orderrows.order.extraFields'
        ])
        ->byYear(request()->year)
        // ->whereHas('emitter', function($query)
        // {
        //     // $query->where('target_id', '6ccfc2e2-26c5-4e26-b7d3-6ed56d73875f');
        //     // $query->where('target_id', '8e923733-d69b-47ac-9399-724df719667c');
        // })
            // ->where('id', 'a151652f-b5f4-4b66-acf3-b20d6c776e4d')
            // ->take(100)
            // ->where('date', '>', Carbon::now()->subYears(1))
            ->get();
    }

}
