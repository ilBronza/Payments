<?php

namespace IlBronza\Payments\Http\Controllers\Paymenttypes;

use IlBronza\CRUD\Traits\CRUDEditUpdateTrait;
use Illuminate\Http\Request;

class PaymenttypeEditUpdateController extends PaymenttypeCRUD
{
    use CRUDEditUpdateTrait;

    public $allowedMethods = ['edit', 'update'];

    public function getGenericParametersFile() : ? string
    {
        return config('payments.models.paymenttype.parametersFiles.create');
    }

    public function edit(string $paymenttype)
    {
        $paymenttype = $this->findModel($paymenttype);

        return $this->_edit($paymenttype);
    }

    public function update(Request $request, $paymenttype)
    {
        $paymenttype = $this->findModel($paymenttype);

        return $this->_update($request, $paymenttype);
    }
}
