<?php

namespace Sven\Minecraft\Exceptions;

use RuntimeException;

class TooManyRequestsException extends RuntimeException
{
    public function __construct($message = null, $code = 0, RuntimeException $previous = null)
    {
        $preset = "You're making too many requests to this resource. Consider caching the results.";

        $this->message = is_null($message) ? $preset : $message;
    }
}
