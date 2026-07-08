<?php

namespace IlBronza\Payments\Models;

use IlBronza\CRUD\Traits\Model\CRUDUseUuidTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cardtype extends BasePaymentsModel
{
    use CRUDUseUuidTrait;

    protected $keyType = 'string';

    static $modelConfigPrefix = 'cardtype';

    static $deletingRelationships = [];

    public function cards(): HasMany
    {
        return $this->hasMany(Card::gpc());
    }

    public function getRelatedCardElements()
    {
        return $this->cards()->with('cardtype', 'cardcircuit', 'bankaccount.bank')->get();
    }
}
