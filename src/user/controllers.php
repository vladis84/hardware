<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\{NotFoundHttpException, AccessDeniedHttpException};

/* @var $app Application */

$user = $app->controllers_factory;

$user->get('/list', function (Request $request) use ($app) {
    $users = $app->userRepository->getAll();

    if (!$app->authorizationChecker()->isGranted('ROLE_ADMIN')) {
        throw new AccessDeniedHttpException('Для просмотра пользователей нужна роль администраторы');
    }
    
    return $app->twig->render('@user/list.html.twig', ['users' => $users, 'usersGroup' => $app->availableUsersGroup]);
});

$user->get('/add', function(Request $request) use ($app) {
    $user = new user\User;
    return $app->twig->render('@user/add.html.twig', ['user' => $user, 'usersGroup' => $app->availableUsersGroup]);
});

$user->get('/edit', function (Request $request) use ($app) {
    // Редактировать можно роли и состояние пользователя.
    $name = $request->get('user-name');
    $user = $app->userRepository->findByUsername($name);
    if (!$user->getUsername()) {
        throw new NotFoundHttpException("Не найден пользователь с именем '{$name}'");
    }
    
    return $app->twig->render('@user/edit.html.twig', ['user' => $user, 'usersGroup' => $app->availableUsersGroup]);
});

$user->post('/save', function (Request $request) use ($app) {
    // Редактировать можно роли и состояние пользователя.
    $name = $request->get('user-name');

    $user = $app->userRepository->findByUsername($name);
    if (!$user) {
        $user = new user\User;
        $user->setUserName($request->get('user-name'));
    }

    $userRole = $request->get('user-role');
    if ($userRole) {
        $user->clearRoles();
        $user->addRole($userRole);
    }
   
    $rawPassword = $request->get('raw-password');
    if ($rawPassword) {
        /* @var $encoder \Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface */
        $encoder = $app['security.default_encoder'];
        $password = $encoder->encodePassword($rawPassword, $user->getSalt());


        $user->setPassword($password);
    }

    // Валидация.
    

    $app->userRepository->save($user);
    
    return $app->redirect('/user/list');
});

$user->get('/ban', function (Request $request) use ($app) {
    $name = $request->get('user-name');
    $user = $app->userRepository->findByUsername($name);
    if (!$user->getUsername()) {
        throw new NotFoundHttpException("Не найден пользователь с именем '{$name}'");
    }

    $isBanned = (bool) $request->get('is-banned', false);
    $user->setBanned($isBanned);
    $app->userRepository->save($user);

    return $app->redirect('/user/list');
});

return $user;
