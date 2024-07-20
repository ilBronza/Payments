<?php

namespace IlBronza\Payments\Http\Controllers\Paymentables;

use IlBronza\CRUD\Traits\CRUDEditUpdateTrait;
use Illuminate\Http\Request;

class PaymentableEditUpdateController extends PaymentableCRUD
{
    use CRUDEditUpdateTrait;

    public $allowedMethods = ['edit', 'update'];

    public function getGenericParametersFile() : ? string
    {
        return config('payments.models.paymentable.parametersFiles.create');
    }

    public function edit(string $paymentable)
    {
        $paymentable = $this->findModel($paymentable);

        return $this->_edit($paymentable);
    }

    public function update(Request $request, $paymentable)
    {
        $paymentable = $this->findModel($paymentable);

        return $this->_update($request, $paymentable);
    }
}
