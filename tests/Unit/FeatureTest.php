<?php namespace Exolnet\Bento\Tests\Unit;

use Exolnet\Bento\Bento;
use Exolnet\Bento\BentoFacade;
use Exolnet\Bento\Feature;
use Exolnet\Bento\Strategy\Stub;
use Exolnet\Bento\Tests\UnitTest;
use Mockery as m;

class FeatureTest extends UnitTest
{
    /**
     * @var \Mockery\MockInterface|\Exolnet\Bento\Bento
     */
    protected $bento;

    /**
     * @var \Exolnet\Bento\Feature
     */
    protected $feature;

    public function setUp()
    {
        $this->bento = m::mock(Bento::class);
        $this->feature = new Feature($this->bento, 'name');
    }

    public function testFeatureIsInstantiable()
    {
        $this->assertInstanceOf(Feature::class, $this->feature);
    }

    public function testFeatureHasNoStrategiesByDefault()
    {
        $this->assertEmpty($this->feature->getStrategies());
        $this->assertEquals(0, $this->feature->countStrategies());
        $this->assertFalse($this->feature->hasStrategies());
    }

    public function testFeatureIsNotLaunchWithoutStrategy()
    {
        $this->assertFalse($this->feature->launch());
    }

    public function testFeatureAimIsFluent()
    {
        $this->bento->shouldReceive('makeStrategy')->with($this->feature, 'everyone');

        $actual = $this->feature->aim('everyone');

        $this->assertSame($actual, $this->feature);
    }

    public function testAddStrategiesToFeature()
    {
        $stub = new Stub(true);

        $this->bento->shouldReceive('makeStrategy')->with($this->feature, 'nobody')->andReturn($stub);
        $this->feature->aim('nobody');

        $strategies = $this->feature->getStrategies();

        $this->assertCount(1, $strategies);
        $this->assertEquals(1, $this->feature->countStrategies());
        $this->assertTrue($this->feature->hasStrategies());

        $this->assertSame($stub, $strategies[0]);
    }

    public function testAddStrategiesThroughMethodCall()
    {
        $stub = new Stub(true);

        $this->bento->shouldReceive('makeStrategy')->with($this->feature, 'visitorPercent', 10)->andReturn($stub);

        $this->feature->visitorPercent(10);

        $strategies = $this->feature->getStrategies();

        $this->assertCount(1, $strategies);
        $this->assertEquals(1, $this->feature->countStrategies());
        $this->assertTrue($this->feature->hasStrategies());

        $this->assertSame($stub, $strategies[0]);
    }
}
