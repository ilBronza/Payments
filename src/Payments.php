<?php

namespace IlBronza\Payments;

use IlBronza\CRUD\Providers\RouterProvider\RoutedObjectInterface;
use IlBronza\CRUD\Traits\IlBronzaPackages\IlBronzaPackagesTrait;
use IlBronza\Payments\Models\Invoice;

class Payments implements RoutedObjectInterface
{
    use IlBronzaPackagesTrait;

    static $packageConfigPrefix = 'payments';

    public function getInvoicesByYearChildren()
    {
        return cache()->rememberForever('_getInvoicesByYearChildren', function()
        {
            $result = [];

            $years = Invoice::gpc()::query()
                ->selectRaw('YEAR(date) as year')
                ->distinct()
                ->orderBy('year', 'desc')
                ->pluck('year')
                ->filter();

            foreach($years as $year)
            {
                $result[] = [
                    'name' => 'invoices.byYear' . $year,
                    'icon' => 'gear',
                    'translatedText' => $year,
                    'href' => $this->route('invoices.byYear', ['year' => $year])
                ];
            }

            return $result;
        });
    }

    public function manageMenuButtons()
    {
        if(! $menu = app('menu'))
            return;

        $settingsButton = $menu->provideButton([
                'text' => 'menu::menu.settings',
                'name' => 'settings',
                'icon' => 'gear',
                'roles' => ['administrator']
            ]);

        $paymentsManagerButton = $menu->createButton([
            'name' => 'paymentsManager',
            'icon' => 'credit-card',
            'text' => 'payments::payments.paymentsManager',
        ]);

        $settingsButton->addChild($paymentsManagerButton);

        $paymentsManagerButton->addChild(
            $menu->createButton([
        	    'name' => 'paymenttypes.list',
        	    'icon' => 'gear',
        	    'text' => 'payments::paymenttypes.list',
        	    'href' => $this->route('paymenttypes.index')
            ])
        );

        $paymentsManagerButton->addChild(
            $menu->createButton([
                'name' => 'cards.list',
                'icon' => 'credit-card',
                'text' => 'payments::cards.list',
                'href' => $this->route('cards.index')
            ])
        );

        $paymentsManagerButton->addChild(
            $menu->createButton([
                'name' => 'cardassignments.list',
                'icon' => 'list',
                'text' => 'payments::cardassignments.list',
                'href' => $this->route('cardAssignments.index')
            ])
        );

        $paymentsManagerButton->addChild(
            $menu->createButton([
                'name' => 'cardtypes.list',
                'icon' => 'list',
                'text' => 'payments::cardtypes.list',
                'href' => $this->route('cardtypes.index')
            ])
        );

        $paymentsManagerButton->addChild(
            $menu->createButton([
                'name' => 'cardcircuits.list',
                'icon' => 'list',
                'text' => 'payments::cardcircuits.list',
                'href' => $this->route('cardcircuits.index')
            ])
        );

        $paymentsManagerButton->addChild(
            $menu->createButton([
                'name' => 'banks.list',
                'icon' => 'building',
                'text' => 'payments::banks.list',
                'href' => $this->route('banks.index')
            ])
        );

        $paymentsManagerButton->addChild(
            $menu->createButton([
                'name' => 'invoices.list',
                'icon' => 'gear',
                'text' => 'payments::invoices.list',
                'href' => $this->route('invoices.index'),
                'children' => $this->getInvoicesByYearChildren()
            ])
        );

        $paymentsManagerButton->addChild(
            $menu->createButton([
                'name' => 'invoices.exportBankTransfers',
                'icon' => 'gear',
                'text' => 'payments::invoices.exportBankTransfers',
                'href' => $this->route('deadlines.exportBankTransefersIndex'),
            ])
        );

        $paymentsManagerButton->addChild(
            $menu->createButton([
                'name' => 'deadlines.list',
                'icon' => 'calendar',
                'text' => 'payments::deadlines.list',
                'href' => $this->route('deadlines.index')
            ])
        );

        $paymentsManagerButton->addChild(
            $menu->createButton([
                'name' => 'paymentables.list',
                'icon' => 'list',
                'text' => 'payments::paymentables.list',
                'href' => $this->route('paymentables.index')
            ])
        );
    }

    public function getRoutePrefix() : ? string
    {
        return config('payments.routePrefix');
    }

}
