<?php

namespace mongo;

/**
 *
 */
class MongoServiceProvider implements \Pimple\ServiceProviderInterface
{
    
    public function register(\Pimple\Container $app)
    {
        $app['mongodb'] = function (\Pimple\Container $app) {
            
            $params = $app['mongodb.options'] ?? [];

            $url = $params['url'] ?? 'mongodb://127.0.0.1/';

            $uriOptions = $params['uriOptions'] ?? [];

            $driverOptions = $params['driverOptions'] ?? [];

            return new \MongoDB\Client($url, $uriOptions, $driverOptions );
        };
    }
}
