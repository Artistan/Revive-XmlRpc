<?php

namespace Artistan\ReviveXmlRpc;

use Illuminate\Support\ServiceProvider;

/**
 * Class Provider
 *
 * @package Artistan\ReviveXmlRpc
 * @
 */
class Provider extends ServiceProvider
{
    /**
     * Alias the services in the boot.
     */
    public function boot()
    {
        // laravel function to publish configuration assets
        if (function_exists('base_path')) {
            $this->publishes([
                __DIR__.'/Assets/Config' => base_path('config'),
            ]);
        }
    }

    /**
     * Register the services.
     */
    public function register()
    {
    }
}
