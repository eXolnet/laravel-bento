<?php

namespace Exolnet\Bento\Tests\Unit\Strategy;

use Exolnet\Bento\Strategy\User;
use Exolnet\Bento\Tests\UnitTest;
use Illuminate\Contracts\Auth\Guard;
use Mockery as m;

class UserTest extends UnitTest
{
    /**
     * @var \Illuminate\Contracts\Auth\Guard|\Mockery\MockInterface
     */
    protected $guard;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->guard = m::mock(Guard::class);
    }

    /**
     * @return void
     */
    public function testLaunchGuest(): void
    {
        $strategy = new User($this->guard);

        $this->guard->shouldReceive('id')->once()->andReturn(null);

        $this->assertFalse($strategy->launch());
    }

    /**
     * @return void
     */
    public function testLaunchAuthenticated(): void
    {
        $strategy = new User($this->guard);

        $this->guard->shouldReceive('id')->once()->andReturn(42);

        $this->assertTrue($strategy->launch());
    }

    /**
     * @return void
     */
    public function testLaunchInvalidIdFromInt(): void
    {
        $strategy = new User($this->guard, 100);

        $this->guard->shouldReceive('id')->once()->andReturn(42);

        $this->assertFalse($strategy->launch());
    }

    /**
     * @return void
     */
    public function testLaunchInvalidIdFromArray(): void
    {
        $strategy = new User($this->guard, [100, 200]);

        $this->guard->shouldReceive('id')->once()->andReturn(42);

        $this->assertFalse($strategy->launch());
    }

    /**
     * @return void
     */
    public function testLaunchValidIdFromInt(): void
    {
        $strategy = new User($this->guard, 42);

        $this->guard->shouldReceive('id')->once()->andReturn(42);

        $this->assertTrue($strategy->launch());
    }

    /**
     * @return void
     */
    public function testLaunchValidIdFromArray(): void
    {
        $strategy = new User($this->guard, [42, 200]);

        $this->guard->shouldReceive('id')->once()->andReturn(42);

        $this->assertTrue($strategy->launch());
    }
}
