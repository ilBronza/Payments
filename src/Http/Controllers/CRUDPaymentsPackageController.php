<?php

namespace IlBronza\Payments\Http\Controllers;

use IlBronza\CRUD\CRUD;

class CRUDPaymentsPackageController extends CRUD
{
    public function getRouteBaseNamePrefix() : ? string
    {
        return config('payments.routePrefix');
    }

    public function setModelClass()
    {
        $this->modelClass = config("payments.models.{$this->configModelClassName}.class");
    }
}
