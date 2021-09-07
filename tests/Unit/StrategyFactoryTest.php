<?php

namespace Exolnet\Bento\Tests\Unit;

use Exolnet\Bento\Feature;
use Exolnet\Bento\Strategy\Everyone;
use Exolnet\Bento\Strategy\Stub;
use Exolnet\Bento\Strategy\User;
use Exolnet\Bento\StrategyFactory;
use Exolnet\Bento\Tests\UnitTest;
use Illuminate\Container\Container;
use Illuminate\Contracts\Auth\Factory as Auth;
use Mockery;

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
     * @var \Exolnet\Bento\StrategyFactory
     */
    protected $factory;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->feature = Mockery::mock(Feature::class);
        $this->container = Mockery::mock(Container::class);
        $this->factory = new StrategyFactory($this->container);
    }

    /**
     * @return void
     * @test
     */
    public function testMakeClassStrategy(): void
    {
        $strategy = $this->factory->make('everyone');

        $this->assertInstanceOf(Everyone::class, $strategy);
    }

    /**
     * @return void
     * @test
     */
    public function testMakeClassStrategyWithOptions(): void
    {
        /** @var \Exolnet\Bento\Strategy\Stub $strategy */
        $strategy = $this->factory->make('stub', [true]);

        $this->assertInstanceOf(Stub::class, $strategy);
        $this->assertTrue($strategy->getState());
    }

    /**
     * @return void
     * @test
     */
    public function testMakeClassWithDependencyInjection(): void
    {
        $auth = Mockery::mock(Auth::class);

        $this->container->shouldReceive('make')->with(Auth::class)->andReturn($auth);

        /** @var \Exolnet\Bento\Strategy\User $strategy */
        $strategy = $this->factory->make('user', [[42]]);

        $this->assertInstanceOf(User::class, $strategy);
        $this->assertEquals([42], $strategy->getUserIds());
    }
}
