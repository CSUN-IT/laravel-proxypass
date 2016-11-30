<?php

namespace CSUNMetaLab\ProxyPass\Providers;

use Illuminate\Support\ServiceProvider;

use Config;
use URL;

class ProxyPassServiceProvider extends ServiceProvider
{
	public function register() {
		if(Config::get('proxypass.proxy_active')) {
			$this->configureProxiedURLs();
			$this->forceProxiedURLs();
		}
	}

	public function boot() {
		$this->publishes([
        	__DIR__.'/../config/proxypass.php' => config_path('proxypass.php'),
    	]);
	}

	private function configureProxiedURLs() {
        $urlOverride = "";
        $proxyHeader = Config::get(
        	'proxypass.proxy_path_header', 'HTTP_X_FORWARDED_PATH');
     
        // check the explicit path header (default is 'HTTP_X_FORWARDED_PATH') for rewrite purposes; this
        // header can take both regular subdomain hosting as well as a path within
        // a subdomain into account
        $forwardedPath = (!empty($_SERVER[$proxyHeader]) ? $_SERVER[$proxyHeader] : "");
        if(!empty($forwardedPath)) {
            $urlOverride = $forwardedPath;
        }
     
        // should there also be a schema override for HTTPS?
        $schemaOverride = "";
        if(!empty($_SERVER['SERVER_PORT'])) {
            $schemaOverride = ($_SERVER['SERVER_PORT'] == '443' ? "https" : "");
        }
        if(!empty($urlOverride)) {
            // does the schema of the URL override begin with https?
            if(starts_with($urlOverride, 'https')) {
                // set the schema override explicitly because the URL override
                // in URL::forceRootUrl() does not take schema into account
                $schemaOverride = "https";
            }
        }
        if(!empty($schemaOverride)) {
            Config::set('proxypass.public_schema_override', $schemaOverride);
        }
     
        // if we now have a URL override, set it
        if(!empty($urlOverride)) {
            if($schemaOverride == "https") {
                // override the root URL to include HTTPS as well
                Config::set('proxypass.public_url_override',
                    str_replace('http:', 'https:', $urlOverride));
            }
            else
            {
                Config::set('proxypass.public_url_override', $urlOverride);
            }
        }
	}

	private function forceProxiedURLs() {
		// override the public schema if an override exists
        $publicSchema = config("proxypass.public_schema_override");
        if(!empty($publicSchema)) {
            URL::forceSchema($publicSchema);
        }

        // override the public root URL if an override exists
        $publicOverride = config("proxypass.public_url_override");
        if(!empty($publicOverride)) {
            URL::forceRootUrl($publicOverride);
        }
	}
}