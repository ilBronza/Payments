<?php

namespace IlBronza\Payments\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Cardtype extends BasePaymentsModel
{
    static $modelConfigPrefix = 'cardtype';

    static $deletingRelationships = [];

    public function cards(): HasMany
    {
        return $this->hasMany(Card::gpc());
    }
}
