<?php

namespace hardware;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 *
 */
class Hardware
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

    public function toArray()
    {
        $result = get_object_vars($this);

        unset($result['_id']);

        return $result;
    }
}
