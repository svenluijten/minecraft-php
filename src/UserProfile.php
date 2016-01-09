<?php

namespace Sven\Minecraft;

use Httpful\Response;
use Sven\Minecraft\Exceptions\TooManyRequestsException;

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
     * The entire player history.
     *
     * @var array|null
     */
    public $history = null;

    /*
    [
        ["name" => "jeb_"],                                   // the first username they had
        ["name" => "username", "changed" => "1414059749000"], // changed their name to this at that microtime
    ]
     */

    /**
     * The URL to the player's skin.
     *
     * @var string|null
     */
    public $skin = null;

    /**
     * The URL to the player's cape
     *
     * @var string|null
     */
    public $cape = null;

    /**
     * Instantiate the UserProfile.
     *
     * @param \Httpful\Response $apiResponse
     * @return void
     */
    public function __construct(Response $apiResponse)
    {
        $this->assureAllData($apiResponse);

        $body = $apiResponse->body;

        $this->setProperties($body);

        return $this;
    }

    /**
     * Make sure the response has all data we need.
     *
     * @param  Httpful\Response $body
     * @return Sven\Minecraft\MinecraftClient
     */
    public function assureAllData($response)
    {
        if ( ! isset($response->body->id)) {
            throw new TooManyRequestsException;
        } elseif ( ! isset($response->body->properties)) {
            return (new MinecraftClient)->fromUuid($response->body->id);
        }
    }

    /**
     * Set all the required properties on the class.
     *
     * @param object $body
     */
    protected function setProperties($body)
    {
        $this->uuid = $body->id;

        $this->name = $body->name;

        $this->history = []; // <---- fix

        dd($body);

        $this->setTextures($body);
    }

    /**
     * Set the cape and skin properties.
     *
     * @param string $input
     */
    protected function setTextures($input)
    {
        $string = base64_decode($input[0]->value);

        $textures = json_decode($string)->textures;

        $this->skin = $textures->SKIN->url;

        if (property_exists($textures, 'CAPE')) {
            $this->cape = $textures->CAPE->url;
        }

        return $this;
    }
}


// base64_decode()'d string
// {
//     "timestamp":1452296171195,
//     "profileId":"a433a004c99a4987b722024fd75be05b",
//     "profileName":"Fenno",
//     "textures": {
//         "SKIN":{
//             "url":"http://textures.minecraft.net/texture/dd4cd5c162e7bd401942a64eef1f66b62213e1e32ec38c17444a458da96121"
//         },
//         "CAPE":{
//             "url":"http://textures.minecraft.net/texture/a7893270f7df67a20ea9c8ab52d7aff23270fc43a11fb3dae62291634af424"
//         }
//     }
// }