<?php

namespace IlBronza\Payments\Http\Controllers\Cards;

use IlBronza\CRUD\Traits\CRUDRelationshipTrait;
use IlBronza\CRUD\Traits\CRUDShowTrait;

class CardShowController extends CardCRUD
{
    use CRUDShowTrait;
    use CRUDRelationshipTrait;

    public $allowedMethods = ['show'];

    public function getGenericParametersFile(): ?string
    {
        return config('payments.models.card.parametersFiles.show');
    }

    public function getRelationshipsManagerClass()
    {
        return config("payments.models.{$this->configModelClassName}.relationshipsManagerClasses.show");
    }

    public function show(string $card)
    {
        $card = $this->findModel($card);

        return $this->_show($card);
    }
}
