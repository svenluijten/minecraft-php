<?php

namespace Sven\Minecraft;

use Sven\Minecraft\Exceptions\InvalidArgumentException;

class Minecraft extends MojangApiClient
{
    /**
     * Get the user by username at an (optionally) given time.
     *
     * @param  string  $username
     * @param  integer $timestamp
     * @return \Sven\Minecraft\Minecraft
     */
    public function fromName($username, $timestamp = null)
    {
        $url = 'https://api.mojang.com/users/profiles/minecraft/' . $username;

        $this->prepare($username, 'username')->request($url, ['at' => $timestamp]);

        return $this;
    }

    /**
     * Get the user by the given UUID.
     *
     * @param  string $uuid
     * @return \Sven\Minecraft\Minecraft
     */
    public function fromUuid($uuid)
    {
        $url = 'https://sessionserver.mojang.com/session/minecraft/profile/' . $uuid;

        $this->prepare($uuid, 'uuid')->request($url);

        return $this;
    }

    /**
     * Return the right data to the user.
     *
     * @return \Sven\Minecraft\UserProfile
     */
    public function get()
    {
        return $this->user;
    }

    /**
     * Return only the specified property.
     *
     * @param  string $property
     * @return string
     * @throws \Sven\Minecraft\Exceptions\InvalidArgumentException
     */
    public function only($property)
    {
        if ( ! property_exists($this->user, $property)) {
            throw (new InvalidArgumentException)->setMessage($property, $this->user);
        }

        return $this->user->{$property};
    }
}
