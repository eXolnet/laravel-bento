<?php

namespace Exolnet\Bento\Tests\Unit;

use Exolnet\Bento\Feature;
use Exolnet\Bento\Strategy\Custom;
use Exolnet\Bento\Strategy\Everyone;
use Exolnet\Bento\Strategy\Stub;
use Exolnet\Bento\Strategy\User;
use Exolnet\Bento\Strategy\UserPercent;
use Exolnet\Bento\StrategyFactory;
use Exolnet\Bento\Tests\UnitTest;
use InvalidArgumentException;
use Illuminate\Container\Container;
use Illuminate\Contracts\Auth\Factory as Auth;
use Mockery as m;

class StrategyFactoryTest extends UnitTest
{
    /**
     * @var \Mockery\MockInterface|\Exolnet\Bento\Feature
     */
    protected $feature;

    /**
     * @var \Mockery\MockInterface|\Illuminate\Container\Container
     */
    protected $container;

    /**
     * @var \Exolnet\Bento\StrategyFactory::__construct
     */
    protected $factory;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->feature = m::mock(Feature::class);
        $this->container = m::mock(Container::class);
        $this->factory = new StrategyFactory($this->container);
    }

    /**
     * @return void
     */
    public function testMakeClassStrategy(): void
    {
        $strategy = $this->factory->make($this->feature, 'everyone');

        $this->assertInstanceOf(Everyone::class, $strategy);
    }

    /**
     * @return void
     */
    public function testMakeClassStrategyWithOptions(): void
    {
        /** @var \Exolnet\Bento\Strategy\Stub $strategy */
        $strategy = $this->factory->make($this->feature, 'stub', true);

        $this->assertInstanceOf(Stub::class, $strategy);
        $this->assertTrue($strategy->getState());
    }

    /**
     * @return void
     */
    public function testMakeClassWithDependencyInjection(): void
    {
        $auth = m::mock(Auth::class);

        $this->container->shouldReceive('make')->with(Auth::class)->andReturn($auth);

        /** @var \Exolnet\Bento\Strategy\User $strategy */
        $strategy = $this->factory->make($this->feature, 'user', [42]);

        $this->assertInstanceOf(User::class, $strategy);
        $this->assertEquals([42], $strategy->getUserIds());
    }

    /**
     * @return void
     */
    public function testMakeClassWithFeatureAware(): void
    {
        $auth = m::mock(Auth::class);

        $this->container->shouldReceive('make')->with(Auth::class)->andReturn($auth);

        /** @var \Exolnet\Bento\Strategy\UserPercent $strategy */
        $strategy = $this->factory->make($this->feature, 'user-percent', 42);

        $this->assertInstanceOf(UserPercent::class, $strategy);
        $this->assertSame($this->feature, $strategy->getFeature());
    }

    /**
     * @return void
     */
    public function testMakeCustomStrategy(): void
    {
        $this->factory->register('custom', function () {
            return true;
        });

        /** @var \Exolnet\Bento\Strategy\Custom $strategy */
        $strategy = $this->factory->make($this->feature, 'custom');

        $this->assertInstanceOf(Custom::class, $strategy);
        $this->assertEquals(0, count($strategy->getOptions()));
    }

    /**
     * @return void
     */
    public function testMakeCustomStrategyWithOptions(): void
    {
        $this->factory->register('custom', function ($customParameter) {
            return true;
        });

        /** @var \Exolnet\Bento\Strategy\Custom $strategy */
        $strategy = $this->factory->make($this->feature, 'custom', 42);

        $this->assertInstanceOf(Custom::class, $strategy);
        $this->assertEquals(1, count($strategy->getOptions()));
    }

    /**
     * @return void
     */
    public function testMakeCustomWithDependencyInjection(): void
    {
        $auth = m::mock(Auth::class);

        $this->container->shouldReceive('make')->with(Auth::class)->andReturn($auth);

        $this->factory->register('custom', function (Auth $auth, $customParameter) {
            return true;
        });

        /** @var \Exolnet\Bento\Strategy\Custom $strategy */
        $strategy = $this->factory->make($this->feature, 'custom', 42);

        $this->assertInstanceOf(Custom::class, $strategy);
        $this->assertEquals(2, count($strategy->getOptions()));
    }

    /**
     * @return void
     */
    public function testMakeCustomWithFeatureAware(): void
    {
        $auth = m::mock(Auth::class);

        $this->container->shouldReceive('make')->with(Auth::class)->andReturn($auth);

        $this->factory->register('custom', function (Auth $auth, Feature $feature, $customParameter) {
            return true;
        });

        /** @var \Exolnet\Bento\Strategy\Custom $strategy */
        $strategy = $this->factory->make($this->feature, 'custom', 42);

        $this->assertInstanceOf(Custom::class, $strategy);
        $this->assertEquals(3, count($strategy->getOptions()));
    }

    /**
     * @throws \ReflectionException
     * @return void
     * @test
     */
    public function testMakeStrategyWithInvalidArgument(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->factory->make($this->feature, 'invalidName');
    }
}
