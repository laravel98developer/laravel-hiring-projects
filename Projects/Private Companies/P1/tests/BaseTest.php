<?php

namespace AliSalehi\Task\Tests;

use AliSalehi\Task\TaskServiceProvider;
use Orchestra\Testbench\TestCase;

class BaseTest extends TestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            TaskServiceProvider::class,
        ];
    }
    
    /**
     * Is a fake test.
     *
     * @test
     */
    public function success(): void
    {
        $this->assertEquals(1, 1);
    }
}
