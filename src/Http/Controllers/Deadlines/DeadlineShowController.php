<?php

namespace IlBronza\Payments\Http\Controllers\Deadlines;

use IlBronza\CRUD\Traits\CRUDShowTrait;

class DeadlineShowController extends DeadlineCRUD
{
    use CRUDShowTrait;

    public $allowedMethods = ['show'];

    public function getGenericParametersFile() : ? string
    {
        return config('payments.models.deadline.parametersFiles.show');
    }

    public function show(string $deadline)
    {
        $deadline = $this->findModel($deadline);

        return $this->_show($deadline);
    }
}
