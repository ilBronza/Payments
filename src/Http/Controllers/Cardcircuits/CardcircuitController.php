<?php

namespace IlBronza\Payments\Http\Controllers\Cardcircuits;

use IlBronza\CRUD\Traits\CRUDCreateStoreTrait;
use IlBronza\CRUD\Traits\CRUDDeleteTrait;
use IlBronza\CRUD\Traits\CRUDEditUpdateTrait;
use IlBronza\CRUD\Traits\CRUDIndexTrait;
use IlBronza\CRUD\Traits\CRUDPlainIndexTrait;
use IlBronza\CRUD\Traits\CRUDShowTrait;
use IlBronza\Payments\Http\Controllers\CRUDPaymentsPackageController;
use Illuminate\Http\Request;

class CardcircuitController extends CRUDPaymentsPackageController
{
    use CRUDPlainIndexTrait;
    use CRUDIndexTrait;
    use CRUDCreateStoreTrait;
    use CRUDShowTrait;
    use CRUDEditUpdateTrait;
    use CRUDDeleteTrait;

    public $configModelClassName = 'cardcircuit';

    public $allowedMethods = [
        'index',
        'create',
        'store',
        'show',
        'edit',
        'update',
        'destroy',
    ];

    public function getGenericParametersFile(): ?string
    {
        return config('payments.models.cardcircuit.parametersFiles.create');
    }

    public function getIndexFieldsArray()
    {
        return config('payments.models.cardcircuit.fieldsGroupsFiles.index')::getTracedFieldsGroup();
    }

    public function getRelatedFieldsArray()
    {
        return $this->getIndexFieldsArray();
    }

    public function getIndexElements()
    {
        return $this->getModelClass()::withCount('cards')->get();
    }

    public function show(string $cardcircuit)
    {
        $cardcircuit = $this->findModel($cardcircuit);

        return $this->_show($cardcircuit);
    }

    public function edit(string $cardcircuit)
    {
        $cardcircuit = $this->findModel($cardcircuit);

        return $this->_edit($cardcircuit);
    }

    public function update(Request $request, $cardcircuit)
    {
        $cardcircuit = $this->findModel($cardcircuit);

        return $this->_update($request, $cardcircuit);
    }

    public function destroy($cardcircuit)
    {
        $cardcircuit = $this->findModel($cardcircuit);

        return $this->_destroy($cardcircuit);
    }
}
