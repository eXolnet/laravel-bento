<?php

namespace Exolnet\Bento\Tests\Integration;

use Exolnet\Bento\Facades\Bento;
use Exolnet\Bento\Tests\IntegrationTest;

class StrategiesTest extends IntegrationTest
{
    /**
     * @var \Exolnet\Bento\Bento
     */
    protected $bento;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->bento = Bento::getFacadeRoot();
    }

    // public function testEnvironmentStrategy(): void
    // {
    //    $this->assertTrue($this->bento->aim('name1', 'environment', 'testing')->launch());
    //    $this->assertFalse($this->bento->aim('name2', 'environment', 'not-the-environment')->launch());
    // }

    /**
     * @return void
     * @test
     */
    public function testEveryoneStrategy(): void
    {
        $this->assertTrue($this->bento->aim('name1', 'everyone')->launch());
    }

    /**
     * @return void
     * @test
     */
    public function testAllStrategy(): void
    {
        $this->assertTrue($this->bento->aim('name1', 'all', function ($strategies) {
            $strategies->aim('everyone')->aim('everyone');
        })->launch());

        $this->assertFalse($this->bento->aim('name2', 'all', function ($strategies) {
            $strategies->aim('nobody')->aim('everyone');
        })->launch());

        $this->assertFalse($this->bento->aim('name3', 'all', function ($strategies) {
            $strategies->aim('nobody')->aim('nobody');
        })->launch());
    }

    /**
     * @return void
     * @test
     */
    public function testAnyStrategy(): void
    {
        $this->assertTrue($this->bento->aim('name1', 'any', function ($strategies) {
            $strategies->aim('everyone')->aim('everyone');
        })->launch());

        $this->assertTrue($this->bento->aim('name2', 'any', function ($strategies) {
            $strategies->aim('nobody')->aim('everyone');
        })->launch());

        $this->assertFalse($this->bento->aim('name3', 'any', function ($strategies) {
            $strategies->aim('nobody')->aim('nobody');
        })->launch());
    }

    /**
     * @return void
     * @test
     */
    public function testNotStrategy(): void
    {
        $this->assertFalse($this->bento->aim('name1', 'not', 'everyone')->launch());
        $this->assertTrue($this->bento->aim('name2', 'not', 'nobody')->launch());
    }

    /**
     * @return void
     * @test
     */
    public function testNobodyStrategy(): void
    {
        $this->assertFalse($this->bento->aim('name1', 'nobody')->launch());
    }

    // public function testUserStrategy(): void
    // {
    //    $this->assertTrue($this->bento->aim('name1', 'user', [1, 2])->launch());
    //    $this->assertFalse$this->bento->aim('name2', 'user', [1, 2])->launch());
    // }

    // public function testVisitorPercentStrategy(): void
    // {
    //    $this->assertFalse($this->bento->aim('name1', 'percent', 0)->launch());
    //    $this->assertTrue($this->bento->aim('name2', 'percent', 100)->launch());
    // }

    /**
     * @return void
     * @test
     */
    public function testCustomStrategy(): void
    {
        $this->bento->defineStrategy('custom1', function () {
            return true;
        });

        $this->assertTrue($this->bento->aim('name1', 'custom1')->launch());

        $this->bento->defineStrategy('custom2', function () {
            return false;
        });

        $this->assertFalse($this->bento->aim('name2', 'custom2')->launch());
    }
}
