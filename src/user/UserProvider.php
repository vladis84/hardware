<?php

namespace user;

use Symfony\Component\Security\Core\User\{UserProviderInterface, UserInterface};
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

/**
 *
 */
class UserProvider implements UserProviderInterface
{
    /**
     *
     * @var UserRepository
     */
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }
    
    public function loadUserByUsername($username): UserInterface
    {
        $user = $this->repository->findByUsername($username);

        if (!$user) {
            $user = new User;
        }

        return $user;
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user instanceof User) {
            $message = sprintf('Instances of "%s" are not supported.', get_class($user));
            throw new UnsupportedUserException($message);
        }

        $user = $this->repository->findByUsername($user->getUsername());

        if (!$user) {
            $user = new User;
        }

        return $user;
    }

    public function supportsClass($class): bool
    {
        return $class == User::class;
    }
}
