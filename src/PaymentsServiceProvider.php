<?php

namespace IlBronza\Payments;

use Illuminate\Support\ServiceProvider;

class PaymentsServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'ilbronza');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'ilbronza');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        if (app() instanceof \Illuminate\Foundation\Application)
            $this->loadRoutesFrom(__DIR__.'/routes/payments.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/payments.php', 'payments');

        // Register the service the package provides.
        $this->app->singleton('payments', function ($app) {
            return new Payments;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['payments'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/payments.php' => config_path('payments.php'),
        ], 'payments.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/ilbronza'),
        ], 'payments.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/ilbronza'),
        ], 'payments.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/ilbronza'),
        ], 'payments.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
