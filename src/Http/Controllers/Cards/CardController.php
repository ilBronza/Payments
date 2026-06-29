<?php

namespace IlBronza\Payments\Http\Controllers\Cards;

use IlBronza\CRUD\Traits\CRUDCreateStoreTrait;
use IlBronza\CRUD\Traits\CRUDDeleteTrait;
use IlBronza\CRUD\Traits\CRUDEditUpdateTrait;
use IlBronza\CRUD\Traits\CRUDIndexTrait;
use IlBronza\CRUD\Traits\CRUDPlainIndexTrait;
use IlBronza\CRUD\Traits\CRUDShowTrait;
use IlBronza\Payments\Http\Controllers\CRUDPaymentsPackageController;
use Illuminate\Http\Request;

class CardController extends CRUDPaymentsPackageController
{
    use CRUDPlainIndexTrait;
    use CRUDIndexTrait;
    use CRUDCreateStoreTrait;
    use CRUDShowTrait;
    use CRUDEditUpdateTrait;
    use CRUDDeleteTrait;

    public $configModelClassName = 'card';

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
        return config('payments.models.card.parametersFiles.create');
    }

    public function getIndexFieldsArray()
    {
        return config('payments.models.card.fieldsGroupsFiles.index')::getTracedFieldsGroup();
    }

    public function getRelatedFieldsArray()
    {
        return $this->getIndexFieldsArray();
    }

    public function getIndexElements()
    {
        return $this->getModelClass()::with('cardtype', 'cardcircuit', 'bank')->get();
    }

    public function show(string $card)
    {
        $card = $this->findModel($card);

        return $this->_show($card);
    }

    public function edit(string $card)
    {
        $card = $this->findModel($card);

        return $this->_edit($card);
    }

    public function update(Request $request, $card)
    {
        $card = $this->findModel($card);

        return $this->_update($request, $card);
    }

    public function destroy($card)
    {
        $card = $this->findModel($card);

        return $this->_destroy($card);
    }
}
