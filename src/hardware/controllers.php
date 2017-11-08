<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/* @var $app Application */

$hardware = $app->controllers_factory;


$hardware->get('/add' , function () use ($app) {
    $hardware = new \hardware\Hardware;

    return $app->twig->render('@hardware/add.html.twig', ['hardware' => $hardware, 'usersGroup' => $app->availableUsersGroup]);
});

$hardware->get('/view', function (Request $request) use ($app) {
    $id = $request->get('id');
    $hardware = $app->hardwareRepository->findById($id);

    if (!$hardware) {
        throw new NotFoundHttpException("Не найдено оборудование с кодом '{$id}'");
    }

    return $app->twig->render('@hardware/view.html.twig', ['hardware' => $hardware, 'usersGroup' => $app->availableUsersGroup]);
});

$hardware->get('/edit', function (Request $request) use ($app) {
    $id = $request->get('id');
    $hardware = $app->hardwareRepository->findById($id);

    if (!$hardware) {
        throw new NotFoundHttpException("Не найдено оборудование с кодом '{$id}'");
    }

    return $app->twig->render('@hardware/edit.html.twig', ['hardware' => $hardware, 'usersGroup' => $app->availableUsersGroup]);
});

$hardware->post('/save', function (Request $request) use ($app) {
    $rawHardware = $request->get('hardware', []);
    $hardware = new \hardware\Hardware;
    $hardware->bsonUnserialize($rawHardware);
    $action = $request->get('action');

    $errors = $app->validator->validate($hardware->getData(), $hardware->getAssert());

    var_dump($errors);
    if (count($errors) > 0) {
        return $app->twig->render("@hardware/{$action}.html.twig", ['hardware' => $hardware, 'errors' => $errors, 'usersGroup' => $app->availableUsersGroup]);
    }

    $app->hardwareRepository->save($hardware);

    return $app->redirect('/hardware/view?id=' . $hardware->getId());
});

$hardware->get('/delete', function(Request $request) use ($app) {
    $id = $request->get('id');
    $hardware = $app->hardwareRepository->findById($id);

    if (!$hardware) {
        throw new NotFoundHttpException("Не найдено оборудование с кодом '{$id}'");
    }

    $app->hardwareRepository->delete($hardware);

    return $app->redirect('/');
});

return $hardware;
