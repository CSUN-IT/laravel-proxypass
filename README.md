# Laravel Proxy Pass
Composer package for Laravel that resolves the correct URLs when behind a proxy

This package is built for version 5.2 of Laravel and on.

To install from Composer, use the following command:

```
composer require csun-metalab/laravel-proxypass:dev-master
```

## Installation

First, add the following lines to your .env file to leverage the proxy attributes:

```
PROXY_ACTIVE=true
PROXY_PATH_HEADER=HTTP_X_FORWARDED_PATH
```

Next, add the service provider to your 'providers' array in Laravel as follows:

```
'providers' => [
   ...
   CSUNMetaLab\ProxyPass\Providers\ProxyPassServiceProvider,
   ...
]
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