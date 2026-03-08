<?php

namespace IlBronza\Payments\Models;

use IlBronza\CRUD\Traits\Model\CRUDUseUuidTrait;
use IlBronza\Payments\Models\BasePaymentsModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceDetail extends BasePaymentsModel
{
    use CRUDUseUuidTrait;

    protected $keyType = 'string';

    static $modelConfigPrefix = 'invoiceDetail';

    static $deletingRelationships = [];

    public $fillable = [
        'invoice_id',
        'description',
        'sorting_index',
        'quantity',
        'unit_price',
        'total_price',
        'vat_rate',
    ];

    public $casts = [
        'quantity' => 'decimal:4',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'vat_rate' => 'decimal:2',
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::gpc());
    }

    public function getInvoice(): ?Invoice
    {
        return $this->invoice;
    }
}
