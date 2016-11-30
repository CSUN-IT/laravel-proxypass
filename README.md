# Laravel Proxy Pass
Composer package for Laravel that resolves the correct URLs when behind a proxy

This package is built for version 5.2 of Laravel and on.

To install from Composer, use the following command:

```composer require csun-metalab/laravel-proxypass```

## Installation

1. Add the following lines to your .env file to leverage the proxy attributes:

```PROXY_ACTIVE=true
PROXY_PATH_HEADER=HTTP_X_FORWARDED_PATH```

2. Run the following Artisan command to publish the configuration:

```php artisan vendor:publish```

3. Add the service provider to your 'providers' array in Laravel as follows:

```'providers' => [
   ...
   CSUNMetaLab\ProxyPass\Providers\ProxyPassServiceProvider,
   ...
]```