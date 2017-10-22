<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/* @var $app Application */

$app ->get('/', function () use ($app) {
    return $app->twig->render('index.html.twig', []);
})->bind('homepage');
    
$app->mount('/hardware', require 'hardware/controllers.php');


$app->get('/user/list', function (Request $request) use ($app) {
    $users = $app->userRepository->getAll();
    return $app->twig->render('/user/list.html.twig', ['users' => $users]);
});



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