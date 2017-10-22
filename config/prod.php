<?php

define('APP_SRC_FOLDER', __DIR__ . '/../src');
define('APP_VAR_FOLDER', __DIR__ . '/../var');

$app['twig.path'] = APP_SRC_FOLDER . '/views';

$app->extend('twig.loader.filesystem', function ($loader) {

    $loader->addPath(APP_SRC_FOLDER . '/hardware/views', 'hardware');
    $loader->addPath(APP_SRC_FOLDER . '/user/views'    , 'user');

    return $loader;
});

$app['twig.options'] = array('cache' => APP_VAR_FOLDER . '/cache/twig');
