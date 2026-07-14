<?php

namespace IlBronza\Payments\Http\Controllers\Cardassignments;

use IlBronza\Buttons\Button;
use IlBronza\CRUD\Traits\CRUDIndexTrait;
use IlBronza\CRUD\Traits\CRUDPlainIndexTrait;

class CardassignmentIndexController extends CardassignmentCRUD
{
    use CRUDPlainIndexTrait;
    use CRUDIndexTrait;

    public $allowedMethods = ['index'];

    public function getIndexFieldsArray()
    {
        return config('payments.models.cardassignment.fieldsGroupsFiles.index')::getTracedFieldsGroup();
    }

    public function getRelatedFieldsArray()
    {
        return $this->getIndexFieldsArray();
    }

    public function getIndexElements()
    {
        return $this->getModelClass()::query()
            ->notExpired()
            ->with('card.bankaccount.bank', 'card.cardtype', 'card.cardcircuit', 'card.holder', 'utilizer')
            ->get();
    }

    public function addIndexButtons()
    {
        $this->addCardsPackageCrossEntityIndexButtons();

        $button = Button::create([
            'href' => app('payments')->route('cardAssignments.history'),
            'text' => __('payments::cardassignments.history'),
            'icon' => 'history',
        ]);

        $button->setHtmlClass('uk-margin-small-right');

        $this->table->addButton($button);
    }
}
