<?php

namespace IlBronza\Payments\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Bank extends BasePaymentsModel
{
    static $modelConfigPrefix = 'bank';

    static $deletingRelationships = [];

    public function cards(): HasMany
    {
        return $this->hasMany(Card::gpc());
    }
}
