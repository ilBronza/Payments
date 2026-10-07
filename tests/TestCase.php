<?php

namespace IlBronza\Payments\Tests;

use IlBronza\AccountManager\AccountManagerServiceProvider;
use IlBronza\Buttons\ButtonsServiceProvider;
use IlBronza\CRUD\CRUDServiceProvider;
use IlBronza\Datatables\DatatablesServiceProvider;
use IlBronza\Form\FormServiceProvider;
use IlBronza\FormField\FormFieldServiceProvider;
use IlBronza\Menu\MenuServiceProvider;
use IlBronza\Payments\PaymentsServiceProvider;
use IlBronza\UikitTemplate\UikitTemplate;
use IlBronza\UikitTemplate\UikitTemplateServiceProvider;
use IlBronza\Ukn\UknServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Spatie\Permission\PermissionServiceProvider;

abstract class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            PermissionServiceProvider::class,
            AccountManagerServiceProvider::class,
            UknServiceProvider::class,
            MenuServiceProvider::class,
            UikitTemplateServiceProvider::class,
            ButtonsServiceProvider::class,
            FormFieldServiceProvider::class,
            FormServiceProvider::class,
            DatatablesServiceProvider::class,
            CRUDServiceProvider::class,
            PaymentsServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app)
    {
        $app['config']->set('app.key', 'base64:' . base64_encode(random_bytes(32)));
        $app['config']->set('app.locale', 'it');
        $app['config']->set('app.template', UikitTemplate::class);
        $app['config']->set('menu.serviceProviders', []);
        $app['config']->set('activitylog.enabled', false);
        $app['config']->set('activitylog.default_auth_driver', null);
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite', 'database' => ':memory:', 'prefix' => '',
        ]);
        $app['config']->set('payments', require __DIR__ . '/../config/payments.php');

        foreach ([\IlBronza\Operators\OperatorsServiceProvider::class => 'operators', \IlBronza\Products\ProductsServiceProvider::class => 'products', \IlBronza\Clients\ClientsServiceProvider::class => 'clients'] as $provider => $key) {
            // External package configuration without booting their application routes or migrations.
            $root = dirname((new \ReflectionClass($provider))->getFileName(), 2);
            $app['config']->set($key, require "{$root}/config/{$key}.php");
        }
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->app['translator']->addNamespace('payments', __DIR__ . '/../resources/lang');

        $user = new \IlBronza\AccountManager\Models\User();
        $user->setRawAttributes(['id' => 1, 'name' => 'Tester']);
        $user->setRelation('roles', new \Illuminate\Database\Eloquent\Collection([
            new \Spatie\Permission\Models\Role(['name' => 'paymentsManager', 'guard_name' => 'web']),
        ]));
        $this->actingAs($user);

        $route = $this->app['router']->getRoutes()->getByName('ibPaymentsinvoices.show');
        $route->bind($this->app['request']);
        $this->app['request']->setRouteResolver(fn () => $route);
    }

    protected function defineDatabaseMigrations()
    {
        \Illuminate\Support\Facades\Schema::create('users', function (\Illuminate\Database\Schema\Blueprint $table) {
            $table->id();
            $table->string('name');
        });
        \Illuminate\Support\Facades\DB::table('users')->insert(['id' => 1, 'name' => 'Tester']);

        $root = dirname((new \ReflectionClass(DatatablesServiceProvider::class))->getFileName(), 2);
        $this->loadMigrationsFrom("{$root}/database/migrations");
    }
}
