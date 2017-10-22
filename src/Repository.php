<?php

/**
 *
 */
abstract class Repository
{
    /**
     * @var \MongoDB\Client
     */
    private $client;

    public function __construct(\MongoDB\Client $client)
    {
        $this->client = $client;
    }

    abstract protected function collection();

    /**
     *
     * @return \MongoDB\Client
     */
    protected function getMongoDBClient()
    {
        return $this->client;
    }
}
