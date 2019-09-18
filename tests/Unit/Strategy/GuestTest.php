<?php

namespace Exolnet\Bento\Tests\Unit\Strategy;

use Exolnet\Bento\Strategy\Guest;
use Exolnet\Bento\Tests\UnitTest;
use Illuminate\Contracts\Auth\Guard;
use Mockery as m;

class GuestTest extends UnitTest
{
    /**
     * @var \Illuminate\Contracts\Auth\Guard|\Mockery\MockInterface
     */
    protected $guard;

    /**
     * @var \Exolnet\Bento\Strategy\Guest
     */
    protected $strategy;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->guard = m::mock(Guard::class);

        $this->strategy = new Guest($this->guard);
    }

    /**
     * @return void
     */
    public function testLaunchGuest(): void
    {
        $this->guard->shouldReceive('guest')->once()->andReturn(true);

        $this->assertTrue($this->strategy->launch());
    }

    /**
     * @return void
     */
    public function testLaunchAuthenticated(): void
    {
        $this->guard->shouldReceive('guest')->once()->andReturn(false);

        $this->assertFalse($this->strategy->launch());
    }
}
