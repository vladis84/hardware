<?php

/**
 * @property \Silex\Provider\ValidatorServiceProvider $validator
 * @property Twig_Environment $twig
 * @property Silex\ControllerCollection $controllers_factory
 * @property hardware\HardwareRepository $hardwareRepository
 * @property user\UserRepository $userRepository
 * @property user\UserGroupRepository $userGroupRepository
 * @property user\UserGroup[] $availableUsersGroup
 */
class Application extends \Silex\Application
{
    public function __get($name)
    {
        return $this[$name];
    }

    /**
     * @return \Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface
     */
    public function authorizationChecker()
    {
        return $this['security.authorization_checker'];
    }

    /**
     * @return \Symfony\Component\Security\Core\Authentication\Token\TokenInterface
     */
    public function token()
    {
        return $this['security.token_storage']->getToken();
    }
}
