<?php

namespace IlBronza\Payments\Http\Controllers;

use Auth;
use IlBronza\Buttons\Button;
use IlBronza\CRUD\CRUD;
use IlBronza\CRUD\Http\Controllers\BasePackageTrait;

class CRUDPaymentsPackageController extends CRUD
{
    use BasePackageTrait;

    static $packageConfigPrefix = 'payments';

    public function getPackageConfigName()
    {
        return static::$packageConfigPrefix;
    }

    public function getRouteBaseNamePrefix() : ? string
    {
        return config('payments.routePrefix');
    }

    public function setModelClass()
    {
        $this->modelClass = config("payments.models.{$this->configModelClassName}.class");
    }

    protected function getCardsEntityIndexRouteMap(): array
    {
        $prefix = config('payments.routePrefix');

        $result = [
            'card' => [
                'route' => "{$prefix}cards.index",
                'text' => 'payments::cards.list',
            ],
            'cardassignment' => [
                'route' => "{$prefix}cardAssignments.index",
                'text' => 'payments::cardassignments.list',
            ],
            'cardtype' => [
                'route' => "{$prefix}cardtypes.index",
                'text' => 'payments::cardtypes.list',
            ],
            'cardcircuit' => [
                'route' => "{$prefix}cardcircuits.index",
                'text' => 'payments::cardcircuits.list',
            ],
            'bank' => [
                'route' => "{$prefix}banks.index",
                'text' => 'payments::banks.list',
            ],
            'bankaccount' => [
                'route' => "{$prefix}bankaccounts.index",
                'text' => 'payments::bankaccounts.list',
            ],
        ];

        if(! Auth::user()->hasRole('cardCreation'))
        {
            unset($result['card']);
            unset($result['cardtype']);
            unset($result['cardcircuit']);
            unset($result['bank']);
            unset($result['bankaccount']);
        }

        return $result;
    }

    protected function addCardsPackageCrossEntityIndexButtons(): void
    {
        if (! isset($this->configModelClassName, $this->table)) {
            return;
        }

        foreach ($this->getCardsEntityIndexRouteMap() as $modelKey => $parameters) {
            if ($modelKey === $this->configModelClassName) {
                continue;
            }

            $button = Button::create([
                'href' => route($parameters['route']),
                'text' => __($parameters['text']),
                'icon' => __("payments::icons.{$modelKey}"),
            ]);

            $button->setHtmlClass('uk-margin-small-right');

            $this->table->addButton($button);
        }
    }
}
