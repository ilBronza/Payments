<?php

namespace IlBronza\Payments\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Cardcircuit extends BasePaymentsModel
{
    static $modelConfigPrefix = 'cardcircuit';

    static $deletingRelationships = [];

    public function cards(): HasMany
    {
        return $this->hasMany(Card::gpc());
    }
}
