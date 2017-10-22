<?php

namespace hardware;

/**
 *
 */
class HardwareRepository extends \Repository
{
    private static $queryOptions = [
       'typeMap' => ['document' => 'hardware\HardwareParam', 'root' => 'hardware\Hardware'],
    ];

    public function save(Hardware $hardware)
    {
        $collection = $this->collection();

        if (!$hardware->_id) {
            $result = $collection->insertOne($hardware);
            $hardware->_id = $result->getInsertedId();
        }
        else {
            $result = $collection->updateOne(['_id' => $hardware->_id], $hardware);

        }
    }

    /**
     * @param stirng $id
     * @return \hardware\Hardware|null
     */
    public function findById($id)
    {
        $collection = $this->collection();
        $hardware = $collection->findOne(['_id' => new \MongoDB\BSON\ObjectId($id)], self::$queryOptions);

        if (empty($hardware)) {
            return null;
        }

        return $hardware;
    }

    protected function collection()
    {
        return $this->getMongoDBClient()->selectCollection('hardware', 'hardware');
    }

}
