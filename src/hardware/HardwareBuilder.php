<?php

namespace hardware;

/**
 *
 */
class HardwareBuilder
{

    /**
     * @param array $values
     * @return Hardware
     */
    public static function make(array $values)
    {
        $hardware = new Hardware;

        $hardware->_id     = $values['id'];
        $hardware->address = $values['address'];
        $hardware->name    = $values['name'];

        $params = $values['params'] ?? [];
        foreach ($params as $param) {
            $hardwareParam = new HardwareParam();

            $hardwareParam->name  = $param['name'];
            $hardwareParam->value = $param['value'];
            $hardwareParam->rule  = $param['rule'];

            $hardware->params[] = $hardwareParam;
        }

        return $hardware;
    }
}
