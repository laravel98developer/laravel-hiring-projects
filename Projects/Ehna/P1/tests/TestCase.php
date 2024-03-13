<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use JeroenG\Explorer\Infrastructure\Elastic\ElasticClientFactory;
use JeroenG\Explorer\Infrastructure\Elastic\FakeResponse;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withHeaders([
            'Accept' => 'application/json',
        ]);

        $fakeResponseFile = fopen(base_path("tests/elastic.json"), 'rb');

        $fakeResponse = new FakeResponse(200, $fakeResponseFile);

        $this->instance(ElasticClientFactory::class, ElasticClientFactory::fake($fakeResponse));
    }
}
