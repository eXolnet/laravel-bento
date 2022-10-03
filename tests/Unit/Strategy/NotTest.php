<?php

namespace Exolnet\Bento\Tests\Unit\Strategy;

use Exolnet\Bento\Bento;
use Exolnet\Bento\Feature;
use Exolnet\Bento\Strategy\Not;
use Exolnet\Bento\Strategy\VisitorPercent;
use Exolnet\Bento\Tests\TestCase;
use InvalidArgumentException;
use Mockery;

class NotTest extends TestCase
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
     * @var \Exolnet\Bento\Strategy\Not
     */
    protected $not;

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
     * @test
     */
    public function testGetFeature(): void
    {
        $this->not = new Not(function () {
            //
        });
        $this->assertNull($this->not->getFeature());

        $this->not->setFeature($this->feature);
        $this->assertEquals($this->feature, $this->not->getFeature());
    }

    /**
     * @return void
     * @test
     */
    public function testUpdateFeatureWithAFeatureAwareStrategy(): void
    {
        $strategy = Mockery::mock(VisitorPercent::class);

        $this->not = new Not($strategy);

        $this->assertNull($this->not->getFeature());
        $strategy->shouldReceive('setFeature')->once()->with($this->feature);

        $this->not->setFeature($this->feature);
        $this->assertEquals($this->feature, $this->not->getFeature());
    }

    /**
     * @return void
     * @test
     */
    public function testLaunchWithoutAnyStrategy(): void
    {
        $this->not = new Not(function () {
            //
        });

        $this->expectException(InvalidArgumentException::class);

        $this->not->launch();
    }
}
