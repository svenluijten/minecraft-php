<?php

namespace Sven\Minecraft;

use Httpful\Response;

class UserProfile
{
    /**
     * The player's UUID.
     *
     * @var string|null
     */
    public $uuid = null;

    /**
     * The player's current username.
     *
     * @var string|null
     */
    public $name = null;

    /**
     * Instantiate the UserProfile.
     *
     * @param \Httpful\Response $apiResponse
     *
     * @return void
     */
    public function __construct(Response $apiResponse)
    {
        $this->uuid = $apiResponse->body->id;

        $this->name = $apiResponse->body->name;

        return $this;
    }

    /**
     * Return a JSON object when the object is treated like a string.
     *
     * @return string
     */
    public function __toString()
    {
        $data = [
            'name' => $this->name,
            'uuid' => $this->uuid,
        ];

        return json_encode($data) ?: '';
    }
}
