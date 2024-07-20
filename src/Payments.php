<?php

namespace IlBronza\Payments;

use IlBronza\CRUD\Providers\RouterProvider\RoutedObjectInterface;
use IlBronza\CRUD\Traits\IlBronzaPackages\IlBronzaPackagesTrait;

class Payments implements RoutedObjectInterface
{
    use IlBronzaPackagesTrait;

    static $packageConfigPrefix = 'payments';

    public function manageMenuButtons()
    {
        if(! $menu = app('menu'))
            return;

        $settingsButton = $menu->provideButton([
                'text' => 'generals.settings',
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
                'name' => 'paymentables.list',
                'icon' => 'list',
                'text' => 'payments::paymenttable.list',
                'href' => $this->route('paymentables.index')
            ])
        );
    }

    public function getRoutePrefix() : ? string
    {
        return config('payments.routePrefix');
    }

}