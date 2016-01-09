<?php

namespace Sven\Minecraft\Exceptions;

use RuntimeException;

class InvalidArgumentException extends RuntimeException
{
    /**
     * Set the affected player's UUID or username.
     *
     * @param  string          $property
     * @param  MinecraftClient $type
     * @return \RuntimeException
     */
    public function setMessage($property, $type)
    {
        $this->message = "The property {$property} is not available on " . get_class($type) . ".";

        return $this;
    }
}
