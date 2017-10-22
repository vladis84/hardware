<?php

namespace hardware;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Устройство.
 */
class Hardware implements \MongoDB\BSON\Persistable
{
    public $_id;
    
    /**
     *
     * @var string
     */
    public $address;

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var HardwareParam[]
     */
    public $params = [];

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('address', new Assert\NotBlank);
        $metadata->addPropertyConstraint('name'   , new Assert\NotBlank);
        $metadata->addPropertyConstraint('params' , new Assert\Count(['min' => 1]));
    }

    public function bsonSerialize()
    {
       $params = [];
        foreach ($this->params as $param) {
            $params[] = $param->bsonSerialize();
        }

        return [
            'address' => $this->address,
            'name'    => $this->name,
            'params'  => $params,
        ];
    }

    public function bsonUnserialize(array $values)
    {
        $this->_id     = isset($values['_id']) ? (string) $values['_id'] : null;
        $this->address = $values['address'] ?? null;
        $this->name    = $values['name']    ?? null;

        $params = $values['params']  ?? [];
        foreach ($params as $param) {
            $hardwareParam = $param;

            if (!$hardwareParam instanceof HardwareParam) {
                $hardwareParam = new HardwareParam;
                $hardwareParam->bsonUnserialize($param);
            }
           
            $this->params[] = $hardwareParam;
        }
    }
}
