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
        $this->app->singleton('minecraft', function () {
            return new Minecraft();
        });
    }
}
