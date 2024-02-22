<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class HelperTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_bigeastSum2number(): void
    {
        $this->assertEquals(
            bigeastSum2number(array(1,7,8,"trdt",8), 12),
            array("message" => "All of array items should be integer or double")
        );

        $this->assertEquals(
            bigeastSum2number(array(1,7,8,14,8), "df"),
            array("message" => "input number should be integer or double")
        );

        $this->assertEquals(
            bigeastSum2number(array(1), 15),
            array("message" => "In input array should exist atleast 2 number")
        );

        $this->assertEquals(
            bigeastSum2number(array(7,6,14,8,6,12,7), 150),
            array("message" => "The sum of none of the numbers in this array is greater than 150")
        );

        $this->assertEquals(
            bigeastSum2number(array(7,6,14,8,6,12,7), 23),
            array(14,12)
        );
    }
}
