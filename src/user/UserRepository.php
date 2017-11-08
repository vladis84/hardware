<?php

namespace user;

/**
 *
 */
class UserRepository extends \Repository
{
    private static $queryOptions = [
       'typeMap' => ['root' => \user\User::class],
    ];

    public function getAll()
    {
        return $this->find([]);
    }

    /**
     * @param string $name
     * @return User|null
     */
    public function findByUsername($name)
    {
        $result = $this->find(['name' => $name])->toArray();

        return $result[0] ?? null;
    }

    public function save(User $user)
    {
        $collection = $this->collection();

        $result = $collection->replaceOne(['name' => $user->getUsername()], $user, ['upsert' => true]);
    }

    private function find($filter)
    {
        $collection = $this->collection();

        return $collection->find($filter, self::$queryOptions);
    }

    protected function collection()
    {
        return $this->getMongoDBClient()->selectCollection('hardware', 'user');
    }
}
