<?php

namespace App\Services;

use Elastic\Elasticsearch\ClientBuilder;

class Elastic
{
    private $client;

    public function __construct()
    {
        $this->client =  ClientBuilder::create()
        ->setHosts([env('ELASTICSEARCH_ENDPOINT')])
        ->setApiKey(env('ELASTICSEARCH_API_KEY'))
        ->build();
    }

    public function index($params)
    {
        $this->client->index($params);
    }

    public function show($params)
    {
        return (json_decode($this->client->get($params)));
    }

    public function list($params)
    {
        return (json_decode($this->client->search($params)));
    }

    public function delete($params): void
    {
        $this->client->delete($params);
    }

}
