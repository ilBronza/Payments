<?php

namespace IlBronza\Payments\Http\Controllers\Cardassignments;

use IlBronza\Buttons\Button;

class CardassignmentHistoryIndexController extends CardassignmentIndexController
{
    public $avoidCreateButton = true;

    public function getIndexElements()
    {
        return $this->getModelClass()::query()
            ->expired()
            ->with('card.bankaccount.bank', 'card.cardtype', 'card.cardcircuit', 'holder', 'utilizer')
            ->get();
    }

    public function addIndexButtons()
    {
        $this->addCardsPackageCrossEntityIndexButtons();

        $button = Button::create([
            'href' => app('payments')->route('cardAssignments.index'),
            'text' => __('payments::cardassignments.currentAssignments'),
            'icon' => 'list',
        ]);

        $button->setHtmlClass('uk-margin-small-right');

        $this->table->addButton($button);
    }
}
