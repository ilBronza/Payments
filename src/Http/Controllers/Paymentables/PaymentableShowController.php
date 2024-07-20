<?php

namespace IlBronza\Payments\Http\Controllers\Paymentables;

use IlBronza\CRUD\Traits\CRUDRelationshipTrait;
use IlBronza\CRUD\Traits\CRUDShowTrait;

class PaymentableShowController extends PaymentableCRUD
{
    use CRUDShowTrait;
    use CRUDRelationshipTrait;

    public $allowedMethods = ['show'];

    public function getGenericParametersFile() : ? string
    {
        return config('payments.models.paymentable.parametersFiles.show');
    }

    public function getRelationshipsManagerClass()
    {
        return config("payments.models.{$this->configModelClassName}.relationshipsManagerClasses.show");
    }

    public function show(string $paymentable)
    {
        $paymentable = $this->findModel($paymentable);

        return $this->_show($paymentable);
    }
}
