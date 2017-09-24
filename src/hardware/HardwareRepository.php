<?php

namespace hardware;

/**
 *
 */
class HardwareRepository extends \Repository
{
    public function save(Hardware $hardware)
    {
        $collection = $this->getMongoDBClient()->selectCollection('hardware', 'hardware');

        if (!$hardware->_id) {
            $result = $collection->insertOne($hardware->toArray());
            $hardware->_id = $result->getInsertedId();
        }
        else {
            $result = $collection->updateOne(['_id' => $hardware->_id], $hardware->toArray());

        }

    }
}
