<?php

namespace IlBronza\Payments\Models;

use Carbon\Carbon;
use IlBronza\CRUD\Traits\Model\CRUDUseUuidTrait;
use IlBronza\Operators\Models\Operator;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CardAssignment extends BasePaymentsModel
{
    use CRUDUseUuidTrait;

    protected $keyType = 'string';

    static $modelConfigPrefix = 'cardassignment';

    static $deletingRelationships = [];

    public $casts = [
        'starts_at' => 'date',
        'ends_at' => 'date',
    ];

    public function card(): BelongsTo
    {
        return $this->belongsTo(Card::gpc());
    }

    public function holder(): BelongsTo
    {
        return $this->belongsTo(Operator::gpc(), 'holder_id');
    }

    public function utilizer(): BelongsTo
    {
        return $this->belongsTo(Operator::gpc(), 'utilizer_id');
    }

    public function getReassignUrl(): string
    {
        return route(config('payments.routePrefix') . 'cardAssignments.reassign', [
            'cardAssignment' => $this,
        ]);
    }

    public function isValid() : bool
    {
        return $this->is_valid;
    }

    public function isExpired() : bool
    {
        return $this->is_expired;
    }

    public function getIsValidAttribute() : bool
    {
        return ! $this->isExpired();
    }

    public function getIsExpiredAttribute() : bool
    {
        if($this->ends_at)
            return $this->ends_at <= Carbon::now();

        return false;
    }

    public function getReassignText(): string
    {
        return __('payments::cardassignments.reassign');
    }
}
