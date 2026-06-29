<?php

namespace IlBronza\Payments\Http\Controllers\Banks;

use IlBronza\CRUD\Traits\CRUDCreateStoreTrait;
use IlBronza\CRUD\Traits\CRUDDeleteTrait;
use IlBronza\CRUD\Traits\CRUDEditUpdateTrait;
use IlBronza\CRUD\Traits\CRUDIndexTrait;
use IlBronza\CRUD\Traits\CRUDPlainIndexTrait;
use IlBronza\CRUD\Traits\CRUDShowTrait;
use IlBronza\Payments\Http\Controllers\CRUDPaymentsPackageController;
use Illuminate\Http\Request;

class BankController extends CRUDPaymentsPackageController
{
    use CRUDPlainIndexTrait;
    use CRUDIndexTrait;
    use CRUDCreateStoreTrait;
    use CRUDShowTrait;
    use CRUDEditUpdateTrait;
    use CRUDDeleteTrait;

    public $configModelClassName = 'bank';

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
        return config('payments.models.bank.parametersFiles.create');
    }

    public function getIndexFieldsArray()
    {
        return config('payments.models.bank.fieldsGroupsFiles.index')::getTracedFieldsGroup();
    }

    public function getRelatedFieldsArray()
    {
        return $this->getIndexFieldsArray();
    }

    public function getIndexElements()
    {
        return $this->getModelClass()::withCount('cards')->get();
    }

    public function show(string $bank)
    {
        $bank = $this->findModel($bank);

        return $this->_show($bank);
    }

    public function edit(string $bank)
    {
        $bank = $this->findModel($bank);

        return $this->_edit($bank);
    }

    public function update(Request $request, $bank)
    {
        $bank = $this->findModel($bank);

        return $this->_update($request, $bank);
    }

    public function destroy($bank)
    {
        $bank = $this->findModel($bank);

        return $this->_destroy($bank);
    }
}
