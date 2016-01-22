# Minecraft API

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Software License][ico-license]](LICENSE.md)

This is a simple package providing you with all the tools to quickstart
development on that Minecraft site you've been craving. Retrieve UUIDs based
on usernames or the other way around with a simple and human-readable API.

## Install

Via [composer](http://getcomposer.org):

```bash
$ composer require sven/minecraft-php
```

If you're using the [Laravel](http://laravel.com) framework, you can add the `MinecraftServiceProvider` to your
`providers` array:

```php
// config/app.php
'providers' => [
    ...
    Sven\Minecraft\MinecraftServiceProvider::class,
    ...
];
```

You may also add the `Minecraft` facade to the `aliases` array to use the facade:

```php
// config/app.php
'aliases' => [
    ...
    'Minecraft' => Sven\Minecraft\Facades\Minecraft::class,
    ...
];
```

## Usage

```php
$minecraft = new Sven\Minecraft\Minecraft;

// Build up the user object from a given username.
$minecraft->fromName($username);

// Supply an optional UNIX timestamp to get the user object of the player who
// owned that username at the time.
$minecraft->fromName($username, time() - (365 * 24 * 60 * 60));

// Build up the user object from a given UUID.
$minecraft->fromUuid($uuid);
```

If you specified the alias in `config/app.php`, you can use the facade:

```php
Minecraft::fromName($username);

Minecraft::fromUuid($uuid);
```

This always returns you the same object (`Sven\Minecraft\Minecraft`). You may use
the `get()` and `only($property)` methods on it to retrieve the data:

```php
$minecraft = new Minecraft;
$user = $minecraft->fromName('jeb_');

$user->get()->name;  // jeb_
$user->get()->uuid;  // 853c80ef3c3749fdaa49938b674adae6

$user->only('name'); // jeb_
$user->only('uuid'); // 853c80ef3c3749fdaa49938b674adae6
```

If you want more flexibility, the `->get()` method now returns a JSON object of
data for your user:

```php
$user->get(); // {"name": "jeb_", "uuid": "853c80ef3c3749fdaa49938b674adae6"}
```

## Rate limiting

Mojang has some rate limiting in place so you are expected to cache the
results. You may send **1 request per minute** to the same resource, and
you may request as many unique resources as you'd like. Keep in mind
Mojang might change this at any time.

## Credits
This is simply a wrapper around [Mojang](https://mojang.com)'s API, beautifully
(yet unofficially) documented at http://wiki.vg/Mojang_API.

## License

`sven/minecraft-php` is licenced under the MIT License (MIT). Please see the
[license file](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/sven/minecraft-php.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-green.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/sven/minecraft-php.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/sven/minecraft-php
[link-downloads]: https://packagist.org/packages/sven/minecraft-php