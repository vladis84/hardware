<?php

namespace user;

/**
 *
 */
class UserProvider implements \Symfony\Component\Security\Core\User\UserProviderInterface
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
    
    public function loadUserByUsername($username): \Symfony\Component\Security\Core\User\UserInterface
    {

    }

    public function refreshUser(\Symfony\Component\Security\Core\User\UserInterface $user): \Symfony\Component\Security\Core\User\UserInterface
    {
        
    }

    public function supportsClass($class): bool
    {

    }
}
