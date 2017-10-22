<?php

use Silex\Provider\AssetServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use Silex\Provider\SecurityServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use mongo\MongoServiceProvider;

$app = new Application();
$app->register(new ServiceControllerServiceProvider());
$app->register(new AssetServiceProvider());
$app->register(new HttpFragmentServiceProvider());
$app->register(new MongoServiceProvider, ['mongodb.options']);
$app->register(new ValidatorServiceProvider);

$app->register(new SecurityServiceProvider);
$app['security.firewalls'] = [
    'admin' => [
        'pattern' => '^/users',
        'form' => ['login_path' => '/login', 'check_path' => '/login_check'],
        'http' => true,
        'users' => function () use ($app) {
            return new user\UserProvider($app->userRepository);
        }
    ]
];

$app->register(new Silex\Provider\TwigServiceProvider);

$app['hardwareRepository'] = function () use ($app) {
    return new \hardware\HardwareRepository($app['mongodb']);
};

$app['userRepository'] = function () use ($app) {
    return new \user\UserRepository($app['mongodb']);
};

return $app;
