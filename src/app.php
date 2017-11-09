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
$app->register(new Silex\Provider\SessionServiceProvider());

$app->register(new SecurityServiceProvider);
$app['security.firewalls'] = [
    'default' => [
        'pattern' => '^.*$',
        'anonymous' => true,
        'form'    => ['login_path'  => '/login' , 'check_path' => '/login_check'],
        'logout'  => ['logout_path' => '/logout', 'invalidate_session' => true],
        'users'   => $app->factory(function ($app) {
            return new user\UserProvider($app->userRepository);
        }),
    ],
];
$app['security.role_hierarchy'] = [
    'ROLE_ADMIN' => ['ROLE_USER'],
];

$app['security.access_rules'] = [
    ['^/user', 'ROLE_ADMIN'],
];

$app->register(new Silex\Provider\TwigServiceProvider);

$app['hardwareRepository'] = function () use ($app) {
    return new \hardware\HardwareRepository($app['mongodb']);
};

$app['userRepository'] = function () use ($app) {
    return new \user\UserRepository($app['mongodb']);
};

$app['userGroupRepository'] = function () use ($app) {
    return new \user\UserGroupRepository($app['mongodb']);
};

$app['availableUsersGroup'] = function () use ($app) {
    $usersGroup = [
        'IS_AUTHENTICATED_ANONYMOUSLY' => 'Гости',
        'ROLE_USER'                    => 'Пользователи',
        'ROLE_ADMIN'                   => 'Администраторы',
    ];

    return $usersGroup;
};

return $app;
