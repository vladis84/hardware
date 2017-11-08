<?php

namespace user;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 *
 */
class User implements UserInterface, \MongoDB\BSON\Persistable
{
    /**
     *
     * @var array
     */
    private $data;

    public function eraseCredentials()
    {

    }

    public function getPassword(): string
    {
        return $this->data['password'] ?? '';
    }

    public function getRoles()
    {
        return $this->data['roles'] ?? [];
    }

    public function clearRoles()
    {
        $this->data['roles'] = [];
    }

    public function addRole($role)
    {
        if (empty($this->data['roles'])) {
            $this->data['roles'] = [];
        }
        
        $this->data['roles'][] = $role;
    }

    public function isBanned()
    {
        return $this->data['isBanned'] ?? false;
    }

    public function getSalt()
    {
        'qawsedrg1dfgc3dfsdf';
    }

    public function setPassword($password)
    {
        $this->data['password'] = $password;
    }

    public function getUsername(): string
    {
        return $this->data['name'] ?? null;
    }

    public function setUserName($userName)
    {
        $this->data['name'] = $userName;
    }

    public function bsonSerialize()
    {
        return $this->data;
    }

    public function bsonUnserialize(array $data)
    {
        $this->data = $data;
    }
}
