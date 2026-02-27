<?php

namespace IlBronza\Payments\Http\Controllers\Deadlines;

use IlBronza\CRUD\Traits\CRUDEditUpdateTrait;
use Illuminate\Http\Request;

class DeadlineEditUpdateController extends DeadlineCRUD
{
    use CRUDEditUpdateTrait;

    public $allowedMethods = ['edit', 'update'];

    public function getGenericParametersFile() : ? string
    {
        return config('payments.models.deadline.parametersFiles.edit');
    }

    public function edit(string $deadline)
    {
        $deadline = $this->findModel($deadline);

        return $this->_edit($deadline);
    }

    public function update(Request $request, string $deadline)
    {
        $deadline = $this->findModel($deadline);

        return $this->_update($request, $deadline);
    }
}
