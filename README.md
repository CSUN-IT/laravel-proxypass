# Laravel Proxy Pass
Composer package for Laravel that resolves the correct absolute URLs when behind a proxy

This package is built for version 5.0 of Laravel and above. It modifies the functionality
of the `url()`, `asset()`, and other helper methods.

To install from Composer, use the following command:

```
composer require csun-metalab/laravel-proxypass
```

## Installation

First, add the following lines to your .env file to leverage the proxy attributes:

```
PROXY_ACTIVE=true
PROXY_PATH_HEADER=HTTP_X_FORWARDED_PATH
```

Next, add the service provider to your `providers` array in Laravel as follows:

```
'providers' => [
   //...

   'CSUNMetaLab\ProxyPass\Providers\ProxyPassServiceProvider',

   // You can also use the following depending on Laravel convention:
   // CSUNMetaLab\ProxyPass\Providers\ProxyPassServiceProvider::class

   //...
],
```

Finally, run the following Artisan command to publish the configuration:

```
php artisan vendor:publish
```

## Environment Variables

The two environment variables you added to your .env file are the following:

### PROXY_ACTIVE

Set this to `true` to enable the proxying functionality or `false` to disable it.

### PROXY_PATH_HEADER

This is the PHP-interpreted value of the request header sent from your proxy. The
default is `HTTP_X_FORWARDED_PATH` (the computed value of `X-Forwarded-Path`)

## Usage Example

Let's say you have an application hosted at `http://laravel.example.com` but that is
not the location you want to show to the world. Instead, you want to show a URL of
`http://www.example.com/laravel` so you place your Laravel application behind a proxy.

However, you notice that while the front page loads properly, none of the URLs you
have written with the `url()`, `asset()`, or other helpers work with that URL and instead
continue writing `http://laravel.example.com` as their base path.

You can configure your proxy to add a request header along with your `ProxyPass` and
`ProxyPassReverse` directives in Apache (ensure you have `mod_headers` enabled and
`mod_proxy` enabled as well):

```
ProxyPass        /laravel http://laravel.example.com
ProxyPassReverse /laravel http://laravel.example.com

<Location /laravel>
RequestHeader set X-Forwarded-Path "http://www.example.com/laravel"
</Location>
```

Now all of your URLs using the `url()`, `asset()`, and other helpers will be written
correctly!
