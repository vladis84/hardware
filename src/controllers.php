<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/* @var $app Application */

$app ->get('/', function () use ($app) {
    $hardwareList = $app->hardwareRepository->getAll();

    return $app->twig->render('index.html.twig', ['hardwareList' => $hardwareList, 'usersGroup' => $app->availableUsersGroup]);
})->bind('homepage');
    
$app->mount('/hardware', require 'hardware/controllers.php');

$app->mount('/user', require 'user/controllers.php');

$app->get('/login', function(Request $request) use ($app) {
    return $app->twig->render('@user/login.html.twig', array(
        'error'         => $app['security.last_error']($request),
        'last_username' => $app['session']->get('_security.last_username'),
    ));
})->bind('login');

$app->get('/logout', function(Request $request) use ($app) {
})->bind('logout');

$app->error(function (\Exception $exception, Request $request, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    // 404.html, or 40x.html, or 4xx.html, or error.html
    $templates = array(
        'errors/' . $code . '.html.twig',
        'errors/' . substr($code, 0, 2) . 'x.html.twig',
        'errors/' . substr($code, 0, 1) . 'xx.html.twig',
        'errors/default.html.twig',
    );

    return new Response($app->twig->resolveTemplate($templates)->render(array('code' => $code)), $code);
});