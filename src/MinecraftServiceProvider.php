<?php

namespace Sven\Minecraft;

use Illuminate\Support\ServiceProvider;

class MinecraftServiceProvider extends ServiceProvider
{
    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->app['minecraft'] = $this->app->share(function ($app) {
            return new Minecraft();
        });
    }
}
