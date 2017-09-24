<?php

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/* @var $app \Silex\Application */


$app ->get('/', function () use ($app) {
       /* @var $app['twig'] Twig_Environment */
       return $app['twig']->render('index.html.twig', []);
    })
->bind('homepage');
    

$app->get('/hardware/add' , function () use ($app) {
    /* @var $app['twig'] Twig_Environment */
    return $app['twig']->render('/hardware/add.html.twig');
});

$app->post('/hardware/save', function (Request $request) use ($app) {
    /* @var $app['twig'] Silex\Provider\ValidatorServiceProvider */
    /* @var $app['twig'] Twig_Environment */
    $repository = $app['hardwareRepository'];

    $rawHardware = $request->get('hardware', []);
    $hardware = \hardware\HardwareBuilder::make($rawHardware);

//    $errors = $app['validator']->validate($hardware);
//    if (count($errors) > 0) {
//        return $app['twig']->render('/hardware/add.html.twig', ['hardware' => $hardware, 'errors' => $errors]);
//    }

    $repository->save($hardware);
    $app->redirect('/hardware/view/' . $hardware->_id);
});

$app->error(function (\Exception $e, Request $request, $code) use ($app) {
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

    return new Response($app['twig']->resolveTemplate($templates)->render(array('code' => $code)), $code);
});