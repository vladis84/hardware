<?php

namespace user;

/**
 *
 */
class UserGroupRepository extends \Repository
{
    private static $queryOptions = [
       'typeMap' => ['root' => \user\UserGroup::class],
    ];

    /**
     * @return UserGroup[]
     */
    public function getAll()
    {
        return $this->find([]);
    }

    protected function collection()
    {
        return $this->getMongoDBClient()->selectCollection('hardware', 'user_roles');
    }

    private function find(array $filter)
    {
        $collection = $this->collection();

        return $collection->find($filter, self::$queryOptions)->toArray();
    }
}
