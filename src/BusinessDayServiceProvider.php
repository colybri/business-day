<?php

namespace Colybri\BusinessDay;

use Illuminate\Support\ServiceProvider;

class BusinessDayServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;
    /**
    * Bootstrap the application.
    *
    * @return void
    */
    public function boot()
    {
        $this->publishes([__DIR__ . '/Publish/config.php' => config_path('business-day.php')]);

        $this->mergeConfigFrom(
            __DIR__ . '/Publish/config.php',
            'business-day'
        );

        $this->app['events']->listen('locale.changed', function () {
            $this->setLocale();
        });

        $this->setLocale();
    }

    /**
     * Set the locale.
     *
     */
    protected function setLocale()
    {
        $locale = $this->app['translator']->getLocale();

        BusinessDay::setLocale($locale);
    }

    /**
    * Register the service provider.
    *
    * @return void
    */
    public function register()
    {
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['BusinessDay'];
    }
}
