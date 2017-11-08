<?php

namespace hardware;

use MongoDB\BSON\ObjectID;

/**
 *
 */
class HardwareRepository extends \Repository
{
    private static $queryOptions = [
       'typeMap' => ['root' => 'hardware\Hardware'],
    ];

    public function save(Hardware $hardware)
    {
        $collection = $this->collection();

        $hardwareId = $hardware->getId();

        $result = $collection->findOneAndReplace(['_id' => new ObjectID($hardwareId)], $hardware, ['upsert' => true]);

        if (empty($hardwareId)) {
            $hardwareId = $result->getUpsertedId();
        }
        
        $hardware->setId($hardwareId);
    }

    /**
     * @param stirng $id
     * @return \hardware\Hardware|null
     */
    public function findById($id)
    {
        $collection = $this->collection();

        if (empty($id)) {
            return null;
        }
        $hardware = $collection->findOne(['_id' => new ObjectID($id)], self::$queryOptions);

        if (empty($hardware)) {
            return null;
        }

        return $hardware;
    }

    public function getAll()
    {
        $collection = $this->collection();
        $hardwareList = $collection->find([], self::$queryOptions);

        if (empty($hardwareList)) {
            return null;
        }

        return $hardwareList;
    }

    public function delete(Hardware $hardware)
    {
        $collection = $this->collection();

        $collection->deleteOne(['_id' => new ObjectId($hardware->getId())], self::$queryOptions);
    }

    protected function collection()
    {
        return $this->getMongoDBClient()->selectCollection('hardware', 'hardware');
    }

}
