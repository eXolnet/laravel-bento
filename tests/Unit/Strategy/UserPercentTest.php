<?php

namespace Exolnet\Bento\Tests\Unit\Strategy;

use Exolnet\Bento\Feature;
use Exolnet\Bento\Strategy\User;
use Exolnet\Bento\Strategy\UserPercent;
use Exolnet\Bento\Tests\UnitTest;
use Illuminate\Contracts\Auth\Guard;
use Mockery as m;

class UserPercentTest extends UnitTest
{
    /**
     * @var \Illuminate\Contracts\Auth\Guard|\Mockery\MockInterface
     */
    protected $guard;

    /**
     * @var \Exolnet\Bento\Feature|\Mockery\MockInterface
     */
    protected $feature;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->feature = m::mock(Feature::class);
        $this->guard = m::mock(Guard::class);
    }

    /**
     * @return void
     */
    public function testLaunchGuest(): void
    {
        $strategy = new UserPercent($this->feature, $this->guard, 100);

        $this->guard->shouldReceive('id')->once()->andReturn(null);

        $this->assertFalse($strategy->launch());
    }

    /**
     * @return void
     */
    public function testLaunchUser100p(): void
    {
        $strategy = new UserPercent($this->feature, $this->guard, 100);

        $this->guard->shouldReceive('id')->once()->andReturn(1);
        $this->feature->shouldReceive('getName')->once()->andReturn('foo');

        $this->assertTrue($strategy->launch());
    }

    /**
     * @return void
     */
    public function testLaunchUser0p(): void
    {
        $strategy = new UserPercent($this->feature, $this->guard, 0);

        $this->guard->shouldReceive('id')->once()->andReturn(1);
        $this->feature->shouldReceive('getName')->once()->andReturn('foo');

        $this->assertFalse($strategy->launch());
    }
}
