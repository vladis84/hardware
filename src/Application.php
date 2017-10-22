<?php

/**
 * @property \Silex\Provider\ValidatorServiceProvider $validator
 * @property Twig_Environment $twig
 * @property hardware\HardwareRepository $hardwareRepository
 * @property user\UserRepository $userRepository
 * @property Silex\ControllerCollection $controllers_factory
 */
class Application extends \Silex\Application
{
    public function __get($name)
    {
        return $this[$name];
    }
}
