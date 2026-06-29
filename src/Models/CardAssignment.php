<?php

namespace IlBronza\Payments\Models;

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
}
