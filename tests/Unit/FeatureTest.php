<?php namespace Exolnet\Bento\Tests\Unit;

use Exolnet\Bento\BentoFacade;
use Exolnet\Bento\Feature;
use Exolnet\Bento\Strategy\Stub;
use Exolnet\Bento\Tests\UnitTest;

class FeatureTest extends UnitTest
{
    public function testFeatureIsInstantiable()
    {
        $actual = new Feature();

        $this->assertInstanceOf(Feature::class, $actual);
    }

    public function testFeatureHasNoStrategiesByDefault()
    {
        $feature = new Feature();

        $this->assertEmpty($feature->getStrategies());
        $this->assertEquals(0, $feature->countStrategies());
        $this->assertFalse($feature->hasStrategies());
    }

    public function testFeatureIsNotLaunchWithoutStrategy()
    {
        $feature = new Feature();

        $this->assertFalse($feature->launch());
    }

    public function testFeatureAimIsFluent()
    {
        $feature = new Feature();

        BentoFacade::shouldReceive('makeStrategy')->with('everyone');

        $actual = $feature->aim('everyone');

        $this->assertSame($actual, $feature);
    }

    public function testAddStrategiesToFeature()
    {
        $feature = new Feature();
        $stub = new Stub(true);

        BentoFacade::shouldReceive('makeStrategy')->with('nobody')->andReturn($stub);
        $feature->aim('nobody');

        $strategies = $feature->getStrategies();

        $this->assertCount(1, $strategies);
        $this->assertEquals(1, $feature->countStrategies());
        $this->assertTrue($feature->hasStrategies());

        $this->assertSame($stub, $strategies[0]);
    }

    public function testAddStrategiesThroughMethodCall()
    {
        $feature = new Feature();
        $stub = new Stub(true);

        BentoFacade::shouldReceive('makeStrategy')->with('visitorPercent', 10)->andReturn($stub);

        $feature->visitorPercent(10);

        $strategies = $feature->getStrategies();

        $this->assertCount(1, $strategies);
        $this->assertEquals(1, $feature->countStrategies());
        $this->assertTrue($feature->hasStrategies());

        $this->assertSame($stub, $strategies[0]);
    }
}
