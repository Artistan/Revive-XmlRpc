<?php

namespace Artistan\ReviveXmlRpc;

use Illuminate\Support\ServiceProvider;

class Provider extends ServiceProvider
{
    /**
     * Alias the services in the boot.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/Assets/Config' => base_path('config'),
        ]);
    }

    /**
     * Register the services.
     */
    public function register()
    {
    }
}
