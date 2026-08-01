<?php

namespace IlBronza\Payments\Models;

use Carbon\Carbon;
use IlBronza\CRUD\Traits\Model\CRUDUseUuidTrait;
use IlBronza\Operators\Models\Operator;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

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

    public function bankaccount(): BelongsTo
    {
        return $this->belongsTo(Bankaccount::gpc());
    }

    public function holder(): BelongsTo
    {
        return $this->belongsTo(Operator::gpc(), 'holder_id');
    }

    public function getHolder() : ? Operator
    {
        return $this->holder;
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(CardAssignment::gpc());
    }

    public function activeAssignments(): HasMany
    {
        return $this->assignments()->notExpired();
    }

    public function currentAssignment(): HasOne
    {
        return $this->hasOne(CardAssignment::gpc())
            ->active()
            ->where('starts_at', '<=', Carbon::now())
            ->orderByDesc('starts_at');
    }

    public function getHasActiveAssignmentAttribute() : bool
    {
        if(array_key_exists('active_assignments_count', $this->attributes))
            return ((int) $this->active_assignments_count) > 0;

        return $this->activeAssignments()->exists();
    }

    public function getRelatedCardassignmentElements()
    {
        return $this->assignments()->with('card.bankaccount.bank', 'card.cardtype', 'card.cardcircuit', 'card.holder', 'utilizer')->get();
    }

    public function getNameAttribute($value) : string
    {
        $name = (string) $value;

        if($this->userCanSeeFullName())
            return $name;

        return $this->maskNameCardNumber($name);
    }

    protected function userCanSeeFullName() : bool
    {
        return Auth::user()?->hasRole('paymentsManager') ?? false;
    }

    protected function maskNameCardNumber(string $name) : string
    {
        if(! preg_match('/^(?<cardNumber>(?:\d{12,19}|\d{4}(?:\s+\d{4}){2,3}))(?<suffix>\s+-\s+.*|)$/', $name, $matches))
            return $name;

        return $this->maskCardNumberPart($matches['cardNumber']) . $matches['suffix'];
    }

    public function getMaskedShortName() : string
    {
        $number = substr($this->getNumber(), -4);

        return "** {$number}";
    }

    public function getNumber()
    {
        return $this->number;
    }

    protected function maskCardNumberPart(string $cardNumber) : string
    {
        $digits = preg_replace('/\D/', '', $cardNumber);
        $maskedNumber = str_repeat('*', strlen($digits) - 4) . substr($digits, -4);

        if(str_contains($cardNumber, ' '))
            return implode(' ', str_split($maskedNumber, 4));

        return $maskedNumber;
    }

    static function boot()
    {
        parent::boot();

        static::saving(function ($model)
        {
            if(! $model->name)
            {
                $number = implode(' ', str_split((string) $model->number, 4));

                $model->name = $number . ' - ' . $model->bankAccount?->bank?->name;
            }
        });
    }

    public function getNameForSelect()
    {
        return "{$this->number} - {$this->cardtype->getName()}";
    }
}
