<?php

namespace IlBronza\Payments\Models;

use IlBronza\CRUD\Traits\Model\CRUDUseUuidTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Card extends BasePaymentsModel
{
    use CRUDUseUuidTrait;

    protected $keyType = 'string';

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

    public function assignments(): HasMany
    {
        return $this->hasMany(CardAssignment::gpc());
    }

    public function getRelatedCardassignmentElements()
    {
        return $this->assignments()->with('card', 'holder', 'utilizer')->get();
    }
}
