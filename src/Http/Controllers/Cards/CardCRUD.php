<?php

namespace IlBronza\Payments\Http\Controllers\Cards;

use IlBronza\Payments\Http\Controllers\CRUDPaymentsPackageController;

class CardCRUD extends CRUDPaymentsPackageController
{
    public $configModelClassName = 'card';
}
