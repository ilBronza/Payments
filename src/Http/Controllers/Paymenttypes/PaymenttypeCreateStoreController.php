<?php

namespace IlBronza\Payments\Http\Controllers\Paymenttypes;

use IlBronza\CRUD\Traits\CRUDCreateStoreTrait;
use IlBronza\CRUD\Traits\CRUDRelationshipTrait;
// use IlBronza\CRUD\Traits\CRUDShowTrait;

class PaymenttypeCreateStoreController extends PaymenttypeCRUD
{
    use CRUDCreateStoreTrait;
    // use CRUDShowTrait;
    use CRUDRelationshipTrait;

    public $allowedMethods = [
        'create',
        'store',
        // 'edit',
        // 'update',
        // 'show'
    ];

    public function getGenericParametersFile() : ? string
    {
        return config('payments.models.paymenttype.parametersFiles.create');
    }

    // public function getRelationshipsManagerClass()
    // {
    //     return config("payments.models.{$this->configModelClassName}.relationshipsManagerClasses.show");
    // }

    // public function show(string $paymenttype)
    // {
    //     $paymenttype = $this->findModel($paymenttype);

    //     return $this->_show($paymenttype);
    // }
}
