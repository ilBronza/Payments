<?php

namespace IlBronza\Payments\Models;

use IlBronza\CRUD\Traits\Model\CRUDUseUuidTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Bankaccount extends BasePaymentsModel
{
    use CRUDUseUuidTrait;

    protected $keyType = 'string';

    protected $fillable = ['iban', 'abi', 'cab', 'account_number', 'bank_id'];

    static $modelConfigPrefix = 'bankaccount';

    static $deletingRelationships = [];

    protected static function boot()
    {
        parent::boot();

        static::saving(function (self $bankaccount) {
            $bankaccount->name = $bankaccount->buildName();
        });
    }

    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::gpc());
    }

    public function cards(): HasMany
    {
        return $this->hasMany(Card::gpc(), 'bankaccount_id');
    }

    public function bankaccountable(): MorphTo
    {
        return $this->morphTo();
    }

    public function getRelatedCardElements()
    {
        return $this->cards()->with('cardtype', 'cardcircuit', 'bankaccount.bank')->get();
    }

    public function getName() : string
    {
        return $this->name ?? $this->buildName();
    }

    protected function buildName() : string
    {
        return collect([
            $this->iban,
            $this->account_number,
            $this->bank?->name,
        ])->filter()->implode(' - ');
    }
}
