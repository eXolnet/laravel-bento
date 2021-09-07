<?php

namespace Exolnet\Bento\Tests\Unit;

use Exolnet\Bento\Bento;
use Exolnet\Bento\Feature;
use Exolnet\Bento\Strategy\Stub;
use Exolnet\Bento\StrategyFactory;
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

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->bento = m::mock(Bento::class);
        $this->feature = new Feature('name');
    }

    /**
     * @return void
     * @test
     */
    public function testFeatureIsInstantiable(): void
    {
        $this->assertInstanceOf(Feature::class, $this->feature);
    }

    /**
     * @return void
     * @test
     */
    public function testFeatureHasNoStrategiesByDefault(): void
    {
        $this->assertEmpty($this->feature->getStrategies());
        $this->assertEquals(0, $this->feature->countStrategies());
        $this->assertFalse($this->feature->hasStrategies());
    }

    /**
     * @return void
     * @test
     */
    public function testFeatureIsNotLaunchWithoutStrategy(): void
    {
        $this->assertFalse($this->feature->launch());
    }

    /**
     * @return void
     * @test
     */
    public function testFeatureAimIsFluent(): void
    {
        $strategyFactory = m::mock(StrategyFactory::class);

        app()->bind(StrategyFactory::class, function () use ($strategyFactory) {
            return $strategyFactory;
        });

        $strategyFactory->shouldReceive('make')->with('everyone', []);

        $actual = $this->feature->everyone();

        $this->assertSame($actual, $this->feature);
    }

    /**
     * @return void
     * @test
     */
    public function testAddStrategiesToFeature(): void
    {
        $stub = new Stub(true);

        $strategyFactory = m::mock(StrategyFactory::class);

        app()->bind(StrategyFactory::class, function () use ($strategyFactory) {
            return $strategyFactory;
        });

        $strategyFactory->shouldReceive('make')->with('nobody', [])->andReturn($stub);
        $this->feature->nobody();

        $strategies = $this->feature->getStrategies();

        $this->assertCount(1, $strategies);
        $this->assertEquals(1, $this->feature->countStrategies());
        $this->assertTrue($this->feature->hasStrategies());

        $this->assertSame($stub, $strategies[0]);
    }

    /**
     * @return void
     * @test
     */
    public function testAddStrategiesThroughMethodCall(): void
    {
        $stub = new Stub(true);

        $strategyFactory = m::mock(StrategyFactory::class);

        app()->bind(StrategyFactory::class, function () use ($strategyFactory) {
            return $strategyFactory;
        });

        $strategyFactory->shouldReceive('make')->with('visitorPercent', [10])->andReturn($stub);

        $this->feature->visitorPercent(10);

        $strategies = $this->feature->getStrategies();

        $this->assertCount(1, $strategies);
        $this->assertEquals(1, $this->feature->countStrategies());
        $this->assertTrue($this->feature->hasStrategies());

        $this->assertSame($stub, $strategies[0]);
    }

    /**
     * @return void
     * @test
     */
    public function testGetName(): void
    {
        self::assertEquals('name', $this->feature->getName());
    }
}
