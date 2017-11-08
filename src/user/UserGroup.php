<?php

namespace user;

/**
 *
 */
class UserGroup implements \MongoDB\BSON\Persistable
{
    private $data;

    public function bsonSerialize()
    {
        return $this->data;
    }

    public function getName()
    {
        return $this->data['name'] ?? null;
    }

    public function getTitle()
    {
        return $this->data['title'] ?? null;
    }

    public function bsonUnserialize(array $data)
    {
        $this->data = $data;
    }

    public function __toString()
    {
        return $this->data['title'] ?? null;
    }
}
