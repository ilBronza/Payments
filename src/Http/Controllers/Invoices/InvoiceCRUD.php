<?php

namespace IlBronza\Payments\Http\Controllers\Invoices;

use IlBronza\Payments\Http\Controllers\CRUDPaymentsPackageController;

class InvoiceCRUD extends CRUDPaymentsPackageController
{
    public $configModelClassName = 'invoice';

    public function getFormFieldsets(string $type)
    {
        if ($type === 'updateEditor' && $this->getUpdateParametersClass()) {
            $this->setUpdateFieldsetsProvider();

            return $this->getUpdateFieldsetsProvider()->getParametersArray();
        }

        return parent::getFormFieldsets($type);
    }
}
