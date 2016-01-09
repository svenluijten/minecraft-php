<?php

namespace Sven\Minecraft;

use Httpful\Request as Client;
use Sven\Minecraft\Exceptions\UserNotFoundException;
use Sven\Minecraft\Exceptions\TooManyRequestsException;

class MojangApiClient
{
    /**
     * @var \Sven\Minecraft\UserProfile
     */
    protected $user;

    /**
     * @var string
     */
    protected $identifier;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var \Httpful\Response
     */
    private $response;

    /**
     * Send the request to Mojang's API.
     *
     * @param  string     $url
     * @param  array|null $options
     * @return \Sven\Minecraft\MojangApiClient
     */
    protected function request($url, array $options = null)
    {
        if ( ! is_null($options) && ! array_key_exists('at', $options) ) {
            $url .= "?at=" . $options['at'];
        }

        $this->response = Client::get($url)->expectsJson()->send();

        return $this->createUser();
    }

    /**
     * Prepare the response for a possible exception.
     *
     * @param  string $identifier
     * @param  string $type
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
     * @return \Sven\Minecraft\MojangApiClient
     * @throws \Sven\Minecraft\Exceptions\UserNotFoundException
     */
    private function assureValidUser()
    {
        if ( ! $this->response->code == 200 || is_null($this->response->body))
            throw (new UserNotFoundException)->setIdentifier($this->identifier, $this->type);

        return $this;
    }

    /**
     * Make sure the response has all the data we need.
     *
     * @return mixed
     * @throws \Sven\Minecraft\Exceptions\TooManyRequestsException
     */
    private function assureAllData()
    {
        $body = $this->response->body;

        if ( ! isset($body->id)) throw new TooManyRequestsException;
        if ( ! isset($body->properties)) return (new Minecraft)->fromUuid($body->id);

        return $this;
    }
}