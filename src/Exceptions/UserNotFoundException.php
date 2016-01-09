<?php

namespace Sven\Minecraft\Exceptions;

use RuntimeException;

class UserNotFoundException extends RuntimeException
{
    /**
     * The affected player's UUID or username.
     *
     * @var string
     */
    protected $identifier;

    /**
     * Set the affected player's UUID or username.
     *
     * @param  string $identifier
     * @return \RuntimeException
     */
    public function setIdentifier($identifier, $type)
    {
        $this->identifier = $identifier;

        $this->message = "Could not find a user with a {$type} of {$identifier}";

        return $this;
    }

    /**
     * Get the affected player's UUID or username.
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }
}
