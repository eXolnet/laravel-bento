<?php

namespace Exolnet\Bento\Tests\Unit\Strategy;

use Exception;
use Exolnet\Bento\Bento;
use Exolnet\Bento\Feature;
use Exolnet\Bento\Strategy\All;
use Exolnet\Bento\Tests\TestCase;
use Mockery;

class AimsStrategiesTest extends TestCase
{
    /**
     * @var \Exolnet\Bento\Bento
     */
    protected $bento;

    /**
     * @var \Exolnet\Bento\Feature
     */
    protected $feature;

    /**
     * @var \Exolnet\Bento\Strategy\All
     */
    protected $logic;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->bento = Mockery::mock(Bento::class);
        $this->feature = Mockery::mock(Feature::class);
    }

    /**
     * @return void
     */
    public function testGetFeature(): void
    {
        $this->logic = new All();
        $this->assertNull($this->logic->getFeature());

        $this->logic->setFeature($this->feature);
        $this->assertEquals($this->feature, $this->logic->getFeature());
    }

    /**
     * @return void
     */
    public function testGetInvalidArgument(): void
    {
        $this->logic = new All();

        $this->expectException(Exception::class);
        $this->logic->invalid;
    }

    /**
     * @return void
     */
    public function testCallInvalidStrategy(): void
    {
        $this->logic = new All();

        $this->expectException(\BadMethodCallException::class);
        $this->logic->invalid();
    }
}
