<?php

namespace Exolnet\Bento\Tests\Integration;

use Exolnet\Bento\Facades\Bento;
use Exolnet\Bento\Strategy\AimsStrategies;
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
    //    $this->assertTrue($this->bento->feature('name1')->environment('testing')->launch());
    //    $this->assertFalse($this->bento->feature('name2')->environment('not-the-environment')->launch());
    // }

    /**
     * @return void
     * @test
     */
    public function testEveryoneStrategy(): void
    {
        $this->assertTrue($this->bento->feature('name1')->everyone()->launch());
    }

    /**
     * @return void
     * @test
     */
    public function testAllStrategy(): void
    {
        $this->assertTrue($this->bento->feature('name1')->all(function (AimsStrategies $aims) {
            $aims
                ->everyone()
                ->everyone();
        })->launch());

        $this->assertFalse($this->bento->feature('name2')->all(function (AimsStrategies $aims) {
            $aims
                ->nobody()
                ->everyone();
        })->launch());

        $this->assertFalse($this->bento->feature('name3')->all(function (AimsStrategies $aims) {
            $aims
                ->nobody()
                ->nobody();
        })->launch());
    }

    /**
     * @return void
     * @test
     */
    public function testAnyStrategy(): void
    {
        $this->assertTrue($this->bento->feature('name1')->any(function (AimsStrategies $aims) {
            $aims
                ->everyone()
                ->everyone();
        })->launch());

        $this->assertTrue($this->bento->feature('name2')->any(function (AimsStrategies $aims) {
            $aims
                ->nobody()
                ->everyone();
        })->launch());

        $this->assertFalse($this->bento->feature('name3')->any(function (AimsStrategies $aims) {
            $aims
                ->nobody()
                ->nobody();
        })->launch());
    }

    /**
     * @return void
     * @test
     */
    public function testNotStrategy(): void
    {
        $this->assertFalse($this->bento->feature('name1')->not('everyone')->launch());
        $this->assertTrue($this->bento->feature('name2')->not('nobody')->launch());
    }

    /**
     * @return void
     * @test
     */
    public function testHigherOrderNotStrategy(): void
    {
        $this->assertFalse($this->bento->feature('name1')->not->everyone()->launch());
        $this->assertTrue($this->bento->feature('name2')->not->nobody()->launch());
    }

    /**
     * @return void
     * @test
     */
    public function testNobodyStrategy(): void
    {
        $this->assertFalse($this->bento->feature('name1')->nobody()->launch());
    }

    // public function testUserStrategy(): void
    // {
    //    $this->assertTrue($this->bento->feature('name1')->user([1, 2])->launch());
    //    $this->assertFalse$this->bento->feature('name2')->user([1, 2])->launch());
    // }

    // public function testVisitorPercentStrategy(): void
    // {
    //    $this->assertFalse($this->bento->feature('name1')->percent(0)->launch());
    //    $this->assertTrue($this->bento->feature('name2')->percent(', 100)->launch());
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

        $this->assertTrue($this->bento->feature('name1')->aim('custom1')->launch());

        $this->bento->defineStrategy('custom2', function () {
            return false;
        });

        $this->assertFalse($this->bento->feature('name2')->aim('custom2')->launch());
    }
}
