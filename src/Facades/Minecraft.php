<?php

namespace Sven\Minecraft\Facades;

use Illuminate\Support\Facades\Facade;

class Minecraft extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'minecraft';
    }
}
