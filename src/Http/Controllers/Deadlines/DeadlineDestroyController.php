<?php

namespace IlBronza\Payments\Http\Controllers\Deadlines;

use IlBronza\CRUD\Traits\CRUDDeleteTrait;

class DeadlineDestroyController extends DeadlineCRUD
{
    use CRUDDeleteTrait;

    public $allowedMethods = ['destroy'];

    public function destroy(string $deadline)
    {
        $deadline = $this->findModel($deadline);

        return $this->_destroy($deadline);
    }
}
