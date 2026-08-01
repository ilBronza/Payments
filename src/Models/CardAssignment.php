<?php

namespace IlBronza\Payments\Models;

use Carbon\Carbon;
use IlBronza\CRUD\Traits\Media\InteractsWithMedia;
use IlBronza\CRUD\Traits\Model\CRUDUseUuidTrait;
use IlBronza\Operators\Models\Operator;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;

class CardAssignment extends BasePaymentsModel implements HasMedia
{
    use InteractsWithMedia;
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

    public function getCard() : ? Card
    {
        return $this->card;
    }

    public function getUtilizer() : ? Operator
    {
        return $this->utilizer;
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

    public function getInlineEditUrl(array $data = []) : string
    {
        return $this->getKeyedRoute('inlineEdit', $data);
    }

    public function getDownloadContractUrl(): string
    {
        return route(config('payments.routePrefix') . 'cardAssignments.downloadContract', [
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

    public function scopeNotExpired($query)
    {
        return $query->active();
    }

    public function scopeActive($query)
    {
        $query->where(function($_query)
        {
            $_query->whereNull('ends_at');
            $_query->orWhere('ends_at', '>', Carbon::now());
        });
    }

    public function scopeExpired($query)
    {
        $query->whereNotNull('ends_at')
            ->where('ends_at', '<=', Carbon::now());
    }

    public function getReassignText(): string
    {
        return __('payments::cardassignments.reassign');
    }

    public function getDownloadContractText(): string
    {
        return __('payments::cardassignments.download_contract');
    }

    public function getNameForSelect()
    {
        return cache()->remember(
            $this->cacheKey('getNameForSelect'),
            1,
            function()
            {
                $pieces = [
                    $this->card->getMaskedShortName()
                ];

                if($value = $this->card->getHolder()->getName())
                    $pieces[] = $value;

                return implode(" | ", $pieces);
            }
        );
    }

    static function getSelfPossibleValuesArray(string $keyField = null, string $nameField = null) : array
    {
        $elements = static::active()->with('card.holder')->get();

        $result = [];

        foreach($elements as $element)
            $result[$element->getKey()] = $element->getNameForSelect();

        return $result;
    }

    static function getSelfPossibleValuesArrayByHolder(string $holderId) : array
    {
        $elements = static::active()->with('card.holder')->get();

        $result = [];

        foreach($elements as $element)
            if($element->getCard()?->holder_id == $holderId)
                $result[$element->getKey()] = $element->getNameForSelect();

        if(count($result) == 0)
            return static::getSelfPossibleValuesArray();

        return $result;
    }

    static function boot()
    {
        parent::boot();

        static::creating(function ($model)
        {
            $query = static::gpc()::notExpired()->where('card_id', $model->card_id);

            $brothers = $query->get();

            foreach($brothers as $brother)
            {
                if((! $brother->ends_at)||($model->starts_at < $brother->ends_at))
                {
                    $brother->ends_at = $model->starts_at;
                    $brother->save();
                }
            }
        });
    }
}
