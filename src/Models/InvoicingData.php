<?php

namespace IlBronza\Payments\Models;

use IlBronza\CRUD\Traits\Model\CRUDUseUuidTrait;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class InvoicingData extends BasePaymentsModel
{
    use CRUDUseUuidTrait;

    protected $keyType = 'string';

    public $incrementing = false;

    static $modelConfigPrefix = 'invoicingData';

    static $deletingRelationships = [];

    protected $fillable = [
        'vat',
        'rea_number',
        'istat_code',
        'ateco_code',
        'pubblica_amministrazione',
        'sdi',
        'split_payment',
    ];

    protected $attributes = [
        'pubblica_amministrazione' => false,
        'split_payment' => false,
    ];

    protected $casts = [
        'pubblica_amministrazione' => 'boolean',
        'split_payment' => 'boolean',
    ];

    public function invoicingDataable(): MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'invoicing_dataable_type', 'invoicing_dataable_id');
    }
}
