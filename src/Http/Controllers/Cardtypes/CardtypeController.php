<?php

namespace IlBronza\Payments\Http\Controllers\Cardtypes;

use IlBronza\CRUD\Traits\CRUDCreateStoreTrait;
use IlBronza\CRUD\Traits\CRUDDeleteTrait;
use IlBronza\CRUD\Traits\CRUDEditUpdateTrait;
use IlBronza\CRUD\Traits\CRUDIndexTrait;
use IlBronza\CRUD\Traits\CRUDPlainIndexTrait;
use IlBronza\CRUD\Traits\CRUDShowTrait;
use IlBronza\Payments\Http\Controllers\CRUDPaymentsPackageController;
use Illuminate\Http\Request;

class CardtypeController extends CRUDPaymentsPackageController
{
    use CRUDPlainIndexTrait;
    use CRUDIndexTrait;
    use CRUDCreateStoreTrait;
    use CRUDShowTrait;
    use CRUDEditUpdateTrait;
    use CRUDDeleteTrait;

    public $configModelClassName = 'cardtype';

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
        return config('payments.models.cardtype.parametersFiles.create');
    }

    public function getIndexFieldsArray()
    {
        return config('payments.models.cardtype.fieldsGroupsFiles.index')::getTracedFieldsGroup();
    }

    public function getRelatedFieldsArray()
    {
        return $this->getIndexFieldsArray();
    }

    public function getIndexElements()
    {
        return $this->getModelClass()::withCount('cards')->get();
    }

    public function show(string $cardtype)
    {
        $cardtype = $this->findModel($cardtype);

        return $this->_show($cardtype);
    }

    public function edit(string $cardtype)
    {
        $cardtype = $this->findModel($cardtype);

        return $this->_edit($cardtype);
    }

    public function update(Request $request, $cardtype)
    {
        $cardtype = $this->findModel($cardtype);

        return $this->_update($request, $cardtype);
    }

    public function destroy($cardtype)
    {
        $cardtype = $this->findModel($cardtype);

        return $this->_destroy($cardtype);
    }
}
