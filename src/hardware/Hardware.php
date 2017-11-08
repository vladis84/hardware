<?php

namespace hardware;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Устройство.
 */
class Hardware implements \MongoDB\BSON\Persistable
{
    /**
     * @var array
     */
    private $data;

    public function getAssert()
    {
        $collection = new Assert\Collection([
            'address' => new Assert\NotBlank,
            'name'    => new Assert\NotBlank,
            'params'  => new Assert\Count(['min' => 1]),
        ]);
        
        $collection->allowExtraFields = true;

        return $collection;
    }

    public function getId()
    {
        $id = null;

        if (isset($this->data['_id'])) {
            $id = (string) $this->data['_id'];
        }

        return $id;
    }

    public function setId($id)
    {
        $this->data['_id'] = $id;
    }

    public function getAddress()
    {
        return $this->data['address'] ?? '';
    }

    public function getName()
    {
        return $this->data['name'] ?? '';
    }

    public function getParams()
    {
        return $this->data['params'] ?? [];
    }

    public function bsonSerialize()
    {
        $data = $this->data;
        
        unset($data['_id']);

        sort($data['params'], SORT_NUMERIC);

        return $data;
    }

    public function bsonUnserialize(array $data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }
}
