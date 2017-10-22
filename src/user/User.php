<?php

namespace user;

/**
 *
 */
class User implements \Symfony\Component\Security\Core\User\UserInterface, \MongoDB\BSON\Persistable
{
    public $_id;

    /**
     *
     * @var string
     */
    public $name;

    public function eraseCredentials()
    {

    }

    public function getPassword(): string
    {
        
    }

    public function getRoles()
    {

    }

    public function getSalt()
    {
        
    }

    public function getUsername(): string
    {

    }

    public function bsonSerialize()
    {
        return (array) $this;
    }

    public function bsonUnserialize(array $data)
    {
        $data += ['_id' => null, 'name' => ''];
        $this->_id = $data['id'];
        $this->name = $data['name'];
    }
}
