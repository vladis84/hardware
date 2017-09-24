<?php

/**
 *
 */
class Repository
{
    /**
     * @var \MongoDB\Client
     */
    private $client;

    public function __construct(\MongoDB\Client $client)
    {
        $this->client = $client;
    }

    /**
     *
     * @return \MongoDB\Client
     */
    protected function getMongoDBClient()
    {
        return $this->client;
    }
}
