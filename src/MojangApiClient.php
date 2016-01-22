<?php

namespace Sven\Minecraft;

use Httpful\Request as Http;
use Sven\Minecraft\Exceptions\TooManyRequestsException;
use Sven\Minecraft\Exceptions\UserNotFoundException;

class MojangApiClient
{
    /**
     * @var \Sven\Minecraft\UserProfile
     */
    protected $user;

    /**
     * @var string
     */
    private $identifier;

    /**
     * @var string
     */
    private $type;

    /**
     * @var \Httpful\Response
     */
    private $response;

    /**
     * Send the request to Mojang's API.
     *
     * @param string     $url
     * @param array|null $options
     *
     * @return \Sven\Minecraft\MojangApiClient
     */
    protected function request($url, array $options = null)
    {
        $url .= !is_null($options) ? '?' . http_build_query($options) : '';

        $this->response = Http::get($url)->expectsJson()->send();

        return $this->createUser();
    }

    /**
     * Prepare the response for a possible exception.
     *
     * @param string $identifier
     * @param string $type
     *
     * @return \Sven\Minecraft\MojangApiClient
     */
    protected function prepare($identifier, $type)
    {
        $this->identifier = $identifier;
        $this->type = $type;

        return $this;
    }

    /**
     * Instantiate a new user UserProfile object.
     *
     * @return \Sven\Minecraft\MojangApiClient
     */
    private function createUser()
    {
        $this->format();

        $this->user = new UserProfile($this->response);

        return $this;
    }

    /**
     * Sanitize the response for better handling.
     *
     * @return \Sven\Minecraft\MojangApiClient
     */
    private function format()
    {
        return $this->assureValidUser()->assureAllData();
    }

    /**
     * Make sure we're dealing with a valid user.
     *
     * @throws \Sven\Minecraft\Exceptions\UserNotFoundException
     *
     * @return \Sven\Minecraft\MojangApiClient
     */
    private function assureValidUser()
    {
        if (!$this->response->code == 200 || is_null($this->response->body)) {
            throw (new UserNotFoundException())->setProperties($this->identifier, $this->type);
        }

        return $this;
    }

    /**
     * Make sure the response has all the data we need.
     *
     * @throws \Sven\Minecraft\Exceptions\TooManyRequestsException
     *
     * @return mixed
     */
    private function assureAllData()
    {
        $body = $this->response->body;

        if (!isset($body->id)) {
            throw new TooManyRequestsException();
        }
        if (!isset($body->properties)) {
            return (new Minecraft())->fromUuid($body->id);
        }

        return $this;
    }
}
