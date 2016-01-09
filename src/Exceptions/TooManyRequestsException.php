<?php

namespace Sven\Minecraft\Exceptions;

use RuntimeException;

class TooManyRequestsException extends RuntimeException
{
    public function __construct($message = null, $code = 0, RuntimeException $previous = null)
    {
        if ( ! is_null($message)) {
            $this->message = $message;
        }

        $this->message = "You're making too many requests for this resource. Consider caching the results.";
    }
}
