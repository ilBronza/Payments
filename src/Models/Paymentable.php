<?php

namespace IlBronza\Payments\Models;

use IlBronza\CRUD\Traits\Model\CRUDCacheTrait;
use IlBronza\CRUD\Traits\Model\CRUDModelTrait;
use IlBronza\CRUD\Traits\Model\CRUDRelationshipModelTrait;
use IlBronza\CRUD\Traits\Model\PackagedModelsTrait;
use IlBronza\Payments\Models\Paymenttype;
use Illuminate\Database\Eloquent\Relations\MorphPivot;

class Paymentable extends MorphPivot
{
    use CRUDCacheTrait;
    use CRUDModelTrait;
    use CRUDRelationshipModelTrait;
    use PackagedModelsTrait {
        PackagedModelsTrait::getRouteBaseNamePrefix insteadof CRUDModelTrait;
        PackagedModelsTrait::getPluralTranslatedClassname insteadof CRUDModelTrait;
        PackagedModelsTrait::getTranslatedClassname insteadof CRUDModelTrait;
    }

    static $packageConfigPrefix = 'payments';
	static $modelConfigPrefix = 'paymentable';
	static $deletingRelationships = [];

    public function paymenttype()
    {
        return $this->belongsTo(
            Paymenttype::getProjectClassName()
        );
    }

    public function paymentable()
    {
        return $this->morphTo();
    }
}
