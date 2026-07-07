<?php

namespace IlBronza\Payments\Http\Controllers\Cardtypes;

use IlBronza\CRUD\Traits\CRUDRelationshipTrait;
use IlBronza\CRUD\Traits\CRUDShowTrait;

class CardtypeShowController extends CardtypeCRUD
{
    use CRUDShowTrait;
    use CRUDRelationshipTrait;

    public $allowedMethods = ['show'];

    public function getGenericParametersFile(): ?string
    {
        return config('payments.models.cardtype.parametersFiles.show');
    }

    public function show(string $cardtype)
    {
        $cardtype = $this->findModel($cardtype);

        return $this->_show($cardtype);
    }
}
