<?php

namespace Sven\Minecraft;

use Httpful\Request as Client;
use Sven\Minecraft\Exceptions\UserNotFoundException;

class MinecraftClient
{
    /**
     * The UserProfile object.
     *
     * @var \Sven\Minecraft\UserProfile
     */
    public $user;

    /**
     * The identifier by which the user is being retrieved.
     *
     * @var string
     */
    protected $identifier;

    /**
     * Get the user by a given username.
     *
     * @param  string   $username
     * @param  int|null $timestamp
     * @return \Sven\Minecraft\UserProfile
     */
    public function fromName($username, $timestamp = null)
    {
        $url = 'https://api.mojang.com/users/profiles/minecraft/';

        $url .= $username . ( ! is_null($timestamp) ? '?at=' . $timestamp : null);

        $this->prepareException($username, 'username');

        $response = $this->send($url);

        return $this->buildUser($response);
    }

    /**
     * Get the user by the given UUID.
     *
     * @param  string $uuid
     * @return \Sven\Minecraft\UserProfile
     */
    public function fromUuid($uuid)
    {
        $url = 'https://sessionserver.mojang.com/session/minecraft/profile/' . $uuid;

        $this->prepareException($uuid, 'uuid');

        $response = $this->send($url);

        return $this->buildUser($response);
    }

    /**
     * Prepare for a possible exception.
     *
     * @param  string $identifier
     * @param  string $type
     * @return void
     */
    protected function prepareException($identifier, $type)
    {
        $this->identifier = $identifier;

        $this->type = $type;
    }

    /**
     * Send the request to the URL provided.
     *
     * @param  string $url
     * @return \Httpful\Response
     */
    protected function send($url)
    {
        return Client::get($url)->expectsJson()->send();
    }

    /**
     * Build a UserProfile from the response.
     *
     * @param  \Httpful\Response $response
     * @return \Sven\Minecraft\UserProfile
     * @throws \Sven\Minecraft\Exceptions\UserNotFoundException
     */
    protected function buildUser($response)
    {
        if ( ! $response->code == 200 || is_null($response->body)) {
            throw (new UserNotFoundException)->setUser($this->identifier, $this->type);
        }

        $user = new UserProfile($response);

        $this->user = $user;

        return $user;
    }
}
