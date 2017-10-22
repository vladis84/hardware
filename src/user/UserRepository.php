<?php

namespace user;

/**
 *
 */
class UserRepository extends \Repository
{
    private static $queryOptions = [
       'typeMap' => ['root' => 'user\User'],
    ];

    public function getAll()
    {
        $collection = $this->collection();
        
        return $collection->find([], self::$queryOptions);
    }

    protected function collection()
    {
        return $this->getMongoDBClient()->selectCollection('hardware', 'user');
    }
}
