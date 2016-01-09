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

// Retrieve UUID (without dashes) based on the username provided.
$minecraft->getUuidFromName($username);

// Supply an optional UNIX timestamp to get the UUID of the user who owned that
// username at the time.
$minecraft->getUuidFromName($username, time() - (365 * 24 * 60 * 60));

// Get array of names the user has played as.
$minecraft->getNameHistory($uuid);

// Extract current username from UUID provided.
$minecraft->getNameFromUuid($uuid);

// Get array of objects with info about each user (username & UUID).
$minecraft->getUuidsFromNames(['Notch', 'jeb_', 'Dinnerbone']);
```

If you specified the alias in `config/app.php`, you can use the facade:

```php
Minecraft::getUuidFromName($username);
```

Of course, all other methods can also be accessed this way.

## Rate limiting

Mojang has some rate limiting in place so you are expected to cache the
results. For everything in this package, the limit is **600 requests every 10
minutes**. Keep in mind Mojang might change this at any time.

## Credits
This is simply a wrapper around [Mojang](https://mojang.com)'s API, beautifully
(yet unofficially) documented at http://wiki.vg/Mojang_API.

## License

`Juggl\Minecraft` is licenced under the MIT License (MIT). Please see the
[license file](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/sven/minecraft.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-green.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/sven/minecraft.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/sven/minecraft
[link-downloads]: https://packagist.org/packages/sven/minecraft
