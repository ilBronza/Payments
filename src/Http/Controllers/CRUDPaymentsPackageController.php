<?php

namespace IlBronza\Payments\Http\Controllers;

use IlBronza\Buttons\Button;
use IlBronza\CRUD\CRUD;

class CRUDPaymentsPackageController extends CRUD
{
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

        return [
            'card' => [
                'route' => "{$prefix}cards.index",
                'text' => 'payments::cards.list',
                'icon' => 'credit-card',
            ],
            'cardassignment' => [
                'route' => "{$prefix}cardAssignments.index",
                'text' => 'payments::cardassignments.list',
                'icon' => 'list',
            ],
            'cardtype' => [
                'route' => "{$prefix}cardtypes.index",
                'text' => 'payments::cardtypes.list',
                'icon' => 'list',
            ],
            'cardcircuit' => [
                'route' => "{$prefix}cardcircuits.index",
                'text' => 'payments::cardcircuits.list',
                'icon' => 'list',
            ],
            'bank' => [
                'route' => "{$prefix}banks.index",
                'text' => 'payments::banks.list',
                'icon' => 'building',
            ],
        ];
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
                'icon' => $parameters['icon'],
            ]);

            $button->setHtmlClass('uk-margin-small-right');

            $this->table->addButton($button);
        }
    }
}
