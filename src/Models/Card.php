<?php

namespace IlBronza\Payments\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Card extends BasePaymentsModel
{
    static $modelConfigPrefix = 'card';

    static $deletingRelationships = [];

    public $casts = [
        'active' => 'boolean',
    ];

    public function cardtype(): BelongsTo
    {
        return $this->belongsTo(Cardtype::gpc());
    }

    public function cardcircuit(): BelongsTo
    {
        return $this->belongsTo(Cardcircuit::gpc());
    }

    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::gpc());
    }
}
