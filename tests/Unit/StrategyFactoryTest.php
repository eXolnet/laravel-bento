<?php namespace Exolnet\Bento\Tests\Unit;

use Exolnet\Bento\Strategy\Custom;
use Exolnet\Bento\Strategy\Everyone;
use Exolnet\Bento\Strategy\Stub;
use Exolnet\Bento\Strategy\User;
use Exolnet\Bento\StrategyFactory;
use Exolnet\Bento\Tests\UnitTest;
use Illuminate\Container\Container;
use Illuminate\Contracts\Auth\Guard;
use Mockery as m;

class StrategyFactoryTest extends UnitTest
{
    /**
     * @var \Mockery\MockInterface|\Illuminate\Container\Container
     */
    protected $container;

    /**
     * @var \Exolnet\Bento\StrategyFactory::__construct
     */
    protected $factory;

    public function setUp()
    {
        $this->container = m::mock(Container::class);
        $this->factory = new StrategyFactory($this->container);
    }

    public function testMakeClassStrategy()
    {
        $strategy = $this->factory->make('everyone');

        $this->assertInstanceOf(Everyone::class, $strategy);
    }

    public function testMakeClassStrategyWithOptions()
    {
        /** @var \Exolnet\Bento\Strategy\Stub $strategy */
        $strategy = $this->factory->make('stub', true);

        $this->assertInstanceOf(Stub::class, $strategy);
        $this->assertTrue($strategy->getState());
    }

    public function testMakeClassWithDependencyInjection()
    {
        $guard = m::mock(Guard::class);

        $this->container->shouldReceive('make')->with(Guard::class)->andReturn($guard);

        /** @var \Exolnet\Bento\Strategy\User $strategy */
        $strategy = $this->factory->make('user', [42]);

        $this->assertInstanceOf(User::class, $strategy);
        $this->assertEquals([42], $strategy->getUserIds());
    }

    public function testMakeCustomStrategy()
    {
        $this->factory->register('custom', function () {
            return true;
        });

        /** @var \Exolnet\Bento\Strategy\Custom $strategy */
        $strategy = $this->factory->make('custom');

        $this->assertInstanceOf(Custom::class, $strategy);
        $this->assertEquals(0, count($strategy->getOptions()));
    }

    public function testMakeCustomStrategyWithOptions()
    {
        $this->factory->register('custom', function ($customParameter) {
            return true;
        });

        /** @var \Exolnet\Bento\Strategy\Custom $strategy */
        $strategy = $this->factory->make('custom', 42);

        $this->assertInstanceOf(Custom::class, $strategy);
        $this->assertEquals(1, count($strategy->getOptions()));
    }

    public function testMakeCustomWithDependencyInjection()
    {
        $guard = m::mock(Guard::class);

        $this->container->shouldReceive('make')->with(Guard::class)->andReturn($guard);

        $this->factory->register('custom', function (Guard $guard, $customParameter) {
            return true;
        });

        /** @var \Exolnet\Bento\Strategy\Custom $strategy */
        $strategy = $this->factory->make('custom', 42);

        $this->assertInstanceOf(Custom::class, $strategy);
        $this->assertEquals(2, count($strategy->getOptions()));
    }
}
