<?php

namespace IlBronza\Payments\Http\Controllers\Invoiceables;

use IlBronza\CRUD\Traits\CRUDCreateStoreTrait;
use IlBronza\CRUD\Traits\CRUDRelationshipTrait;
// use IlBronza\CRUD\Traits\CRUDShowTrait;

class InvoiceableCreateStoreController extends InvoiceableCRUD
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
        return config('payments.models.invoiceable.parametersFiles.create');
    }

    // public function getRelationshipsManagerClass()
    // {
    //     return config("payments.models.{$this->configModelClassName}.relationshipsManagerClasses.show");
    // }

    // public function show(string $paymentable)
    // {
    //     $paymentable = $this->findModel($paymentable);

    //     return $this->_show($paymentable);
    // }
}
