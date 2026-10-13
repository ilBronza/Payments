<?php

namespace IlBronza\Payments\Models\Traits;

use IlBronza\Payments\Models\Bankaccount;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait InteractsWithBankaccounts
{
    public function bankaccounts(): MorphMany
    {
        return $this->morphMany(Bankaccount::gpc(), 'bankaccountable');
    }

    public function getRelatedBankaccountElements(): Collection
    {
        return $this->bankaccounts()->with('bank')->withCount('cards')->get();
    }
}
