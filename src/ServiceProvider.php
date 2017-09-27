<?php

namespace Sjorsvanleeuwen\ExtendedResourceRegistrar;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Register the router instance.
     *
     * @return void
     */
    public function register()
    {
        $this->app->extend('router', function ($router, $app) {
            return new Router($app['events'], $app);
        });
    }
}