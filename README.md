# bitly

[![Build Status](https://travis-ci.org/gabrielkaputa/bitly.svg?branch=master)](https://travis-ci.org/gabrielkaputa/bitly)
[![Latest Stable Version](https://poser.pugx.org/gabrielkaputa/bitly/v/stable)](https://packagist.org/packages/gabrielkaputa/bitly)

PHP library to consume bit.ly API

## Installation

The recommended way to install this library is through [Composer](http://getcomposer.org/doc/00-intro.md).

```shell
composer install gabrielkaputa/bitly
```

## Usage

First of all, [create a bit.ly account](https://bitly.com/) if you don't have one already.

If all you need to do is to create shortlinks on behalf of a single user or site,
all you need is to [get your generic access token](https://bitly.com/a/oauth_apps).
When done, you can create shortlinks like this:

```php
require_once("vendor/autoload.php");

$bitly = \GabrielKaputa\Bitly::withGenericAccessToken(GENERIC_ACCESS_TOKEN);
$short_url = $bitly->shortenUrl($long_url);
```

Another option is when you are working with multiple end-users or to pull any information on a user level
for your own account. In this case you will need to [register your application](http://dev.bitly.com/my_apps.html)
to get your `CLIENT_ID` and `CLIENT_SECRET`. When done, you can create shortlinks like this:

```php
require_once("vendor/autoload.php");

$bitly = \GabrielKaputa\Bitly::withCredentials(CLIENT_ID, CLIENT_SECRET, USERNAME, PASSWORD);
$short_url = $bitly->shortenUrl($long_url);
```