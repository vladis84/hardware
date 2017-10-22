<?php

namespace hardware;

/**
 *
 */
class HardwareParam implements \MongoDB\BSON\Persistable
{
    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var string
     */
    public $value;

    /**
     *
     * @var string
     */
    public $rule;


    public function bsonSerialize()
    {
        return [
            'name' => $this->name,
            'value' => $this->value,
            'rule' => $this->rule,
        ];
    }

    public function bsonUnserialize(array $data)
    {
        $this->name  = $data['name'];
        $this->value = $data['value'];
        $this->rule  = $data['rule'];
    }
}
