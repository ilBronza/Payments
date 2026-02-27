<?php

namespace IlBronza\Payments\Models;

use IlBronza\CRUD\Traits\Model\CRUDUseUuidTrait;
use IlBronza\Payments\Models\BasePaymentsModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Deadline extends BasePaymentsModel
{
    use CRUDUseUuidTrait;

    protected $keyType = 'string';

    static $modelConfigPrefix = 'deadline';

    static $deletingRelationships = [];

    public $fillable = [
        'invoice_id',
        'due_date',
        'income',
        'vat',
        'tota_cost',
    ];

    public $casts = [
        'due_date' => 'date',
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::gpc());
    }

    public function getInvoice(): ?Invoice
    {
        return $this->invoice;
    }

    public function getName() : ? string
    {
        return $this->total_cost;
    }

    public function scopeToExport($query)
    {
        $query->whereNull('exported_at')
            ->whereHas('invoice', function($_query)
            {
                $_query->where('approved', true)->where('confirmed', true);
            });
    }

    public function scopeBankTransfer($query)
    {
        $query->where('temp_ist_scad', 'B');
    }
}
