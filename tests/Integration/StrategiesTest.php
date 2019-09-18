<?php

namespace Exolnet\Bento\Tests\Integration;

use Exolnet\Bento\BentoFacade;
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

        $this->bento = BentoFacade::getFacadeRoot();
    }

//    public function testEnvironmentStrategy()
//    {
//        $this->assertTrue($this->bento->aim('name1', 'environment', 'testing')->launch());
//        $this->assertFalse($this->bento->aim('name2', 'environment', 'not-the-environment')->launch());
//    }

    /**
     * @return void
     */
    public function testEveryoneStrategy(): void
    {
        $this->assertTrue($this->bento->aim('name1', 'everyone')->launch());
    }

    /**
     * @return void
     */
    public function testLogicAndStrategy(): void
    {
        $this->assertTrue($this->bento->aim('name1', 'logic-and', function ($strategies) {
            $strategies->aim('everyone')->aim('everyone');
        })->launch());

        $this->assertFalse($this->bento->aim('name2', 'logic-and', function ($strategies) {
            $strategies->aim('nobody')->aim('everyone');
        })->launch());

        $this->assertFalse($this->bento->aim('name3', 'logic-and', function ($strategies) {
            $strategies->aim('nobody')->aim('nobody');
        })->launch());
    }

    /**
     * @return void
     */
    public function testLogicOrStrategy(): void
    {
        $this->assertTrue($this->bento->aim('name1', 'logic-or', function ($strategies) {
            $strategies->aim('everyone')->aim('everyone');
        })->launch());

        $this->assertTrue($this->bento->aim('name2', 'logic-or', function ($strategies) {
            $strategies->aim('nobody')->aim('everyone');
        })->launch());

        $this->assertFalse($this->bento->aim('name3', 'logic-or', function ($strategies) {
            $strategies->aim('nobody')->aim('nobody');
        })->launch());
    }

    /**
     * @return void
     */
    public function testLogicNotStrategy(): void
    {
        $this->assertFalse($this->bento->aim('name1', 'logic-not', 'everyone')->launch());
        $this->assertTrue($this->bento->aim('name2', 'logic-not', 'nobody')->launch());
    }

    /**
     * @return void
     */
    public function testNobodyStrategy(): void
    {
        $this->assertFalse($this->bento->aim('name1', 'nobody')->launch());
    }

//    public function testUserStrategy()
//    {
//        $this->assertTrue($this->bento->aim('name1', 'user', [1, 2])->launch());
//        $this->assertFalse$this->bento->aim('name2', 'user', [1, 2])->launch());
//    }

//    public function testVisitorPercentStrategy()
//    {
//        $this->assertFalse($this->bento->aim('name1', 'percent', 0)->launch());
//        $this->assertTrue($this->bento->aim('name2', 'percent', 100)->launch());
//    }

    /**
     * @return void
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
