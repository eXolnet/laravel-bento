<?php

namespace Exolnet\Bento\Tests\Integration;

use Exolnet\Bento\Bento;
use Exolnet\Bento\BentoFacade;
use Exolnet\Bento\StrategyFactory;
use Exolnet\Bento\Tests\IntegrationTest;
use PHPUnit_Framework_TestCase;

class StrategiesTest extends IntegrationTest
{
    /**
     * @var \Exolnet\Bento\Bento
     */
    protected $bento;

    public function setUp()
    {
        parent::setUp();

        $this->bento = BentoFacade::getFacadeRoot();
    }

//    public function testEnvironmentStrategy()
//    {
//        $this->assertTrue($this->bento->aim('name1', 'environment', 'testing')->launch());
//        $this->assertFalse($this->bento->aim('name2', 'environment', 'not-the-environment')->launch());
//    }

    public function testEveryoneStrategy()
    {
        $this->assertTrue($this->bento->aim('name1', 'everyone')->launch());
    }

    public function testLogicAndStrategy()
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

    public function testLogicOrStrategy()
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

    public function testLogicNotStrategy()
    {
        $this->assertFalse($this->bento->aim('name1', 'logic-not', 'everyone')->launch());
        $this->assertTrue($this->bento->aim('name2', 'logic-not', 'nobody')->launch());
    }

    public function testNobodyStrategy()
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

    public function testCustomStrategy()
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
