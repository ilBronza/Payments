<?php

namespace IlBronza\Payments\Http\Controllers\Paymentables;

use IlBronza\CRUD\Traits\CRUDDeleteTrait;

class PaymentableDestroyController extends PaymentableCRUD
{
    use CRUDDeleteTrait;

    public $allowedMethods = ['destroy'];

    public function destroy($paymentable)
    {
        $paymentable = $this->findModel($paymentable);

        return $this->_destroy($paymentable);
    }
}