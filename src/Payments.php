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
			    'name' => 'invoices.list',
			    'icon' => 'gear',
			    'text' => 'payments::invoices.list',
			    'href' => $this->route('invoices.index'),
                'children' => $this->getInvoicesByYearChildren()
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