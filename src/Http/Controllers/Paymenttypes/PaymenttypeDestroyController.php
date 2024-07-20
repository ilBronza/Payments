<?php

namespace IlBronza\Payments\Http\Controllers\Paymenttypes;

use IlBronza\CRUD\Traits\CRUDDeleteTrait;

class PaymenttypeDestroyController extends PaymenttypeCRUD
{
    use CRUDDeleteTrait;

    public $allowedMethods = ['destroy'];

    public function destroy($paymenttype)
    {
        $paymenttype = $this->findModel($paymenttype);

        return $this->_destroy($paymenttype);
    }
}