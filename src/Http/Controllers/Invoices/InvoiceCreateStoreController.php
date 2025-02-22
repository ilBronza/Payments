<?php

namespace IlBronza\Payments\Http\Controllers\Invoices;

use IlBronza\CRUD\Traits\CRUDCreateStoreTrait;
use IlBronza\CRUD\Traits\CRUDRelationshipTrait;
// use IlBronza\CRUD\Traits\CRUDShowTrait;

class InvoiceCreateStoreController extends InvoiceCRUD
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
        return config('payments.models.invoice.parametersFiles.create');
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
