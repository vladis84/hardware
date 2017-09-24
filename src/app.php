<?php

use Silex\Application;
use Silex\Provider\AssetServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use Silex\Provider\SecurityServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Symfony\Component\Security\Core\User\User;
use mongo\MongoServiceProvider;

$app = new Application();
$app->register(new ServiceControllerServiceProvider());
$app->register(new AssetServiceProvider());
$app->register(new TwigServiceProvider());
$app->register(new HttpFragmentServiceProvider());
$app->register(new MongoServiceProvider, ['mongodb.options']);
$app->register(new ValidatorServiceProvider);
//$app->register(
//    new SecurityServiceProvider,
//    ['security.firewalls' => array(
//    'main' => array(
//        'pattern' => '^.*$',
//        'anonymous' => true,
//        'form' => array(
//            'login_path' => '/login',
//            'check_path' => '/login_check',
//        ),
//        'logout' => array('logout_path' => '/logout'),
//        'users' => $app->share(function () use ($app) {
//            return new UserProvider($app['db']);
//        }),
//    )
//),
//'security.access_rules' => array(
//    array('^/private', 'ROLE_USER'),
//    array('^.*$', 'IS_AUTHENTICATED_ANONYMOUSLY')
//)]);

$app['twig'] = $app->extend('twig', function ($twig, $app) {
    // add custom globals, filters, tags, ...

    return $twig;
});

$app['hardwareRepository'] = function () use ($app) {
    return new \hardware\HardwareRepository($app['mongodb']);
};

return $app;
