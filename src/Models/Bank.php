<?php

namespace IlBronza\Payments\Models;

use IlBronza\CRUD\Traits\Model\CRUDUseUuidTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bank extends BasePaymentsModel
{
    use CRUDUseUuidTrait;

    protected $keyType = 'string';

    static $modelConfigPrefix = 'bank';

    static $deletingRelationships = [];

    public function cards(): HasMany
    {
        return $this->hasMany(Card::gpc());
    }
}
