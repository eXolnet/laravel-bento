<?php

namespace Exolnet\Bento\Tests\Unit\Strategy;

use Exolnet\Bento\Feature;
use Exolnet\Bento\Strategy\UserPercent;
use Exolnet\Bento\Tests\TestCase;
use Illuminate\Contracts\Auth\Factory as Auth;
use Mockery;

class UserPercentTest extends TestCase
{
    /**
     * @var \Illuminate\Contracts\Auth\Factory|\Mockery\MockInterface
     */
    protected $auth;

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

        $this->feature = Mockery::mock(Feature::class);
        $this->auth = Mockery::mock(Auth::class);
    }

    /**
     * @return void
     */
    public function testLaunchGuest(): void
    {
        $strategy = new UserPercent($this->auth, 100);
        $strategy->setFeature($this->feature);

        $this->auth->shouldReceive('guard->id')->once()->andReturn(null);

        $this->assertFalse($strategy->launch());
    }

    /**
     * @return void
     */
    public function testLaunchUser100p(): void
    {
        $strategy = new UserPercent($this->auth, 100);
        $strategy->setFeature($this->feature);

        $this->auth->shouldReceive('guard->id')->once()->andReturn(1);
        $this->feature->shouldReceive('getName')->once()->andReturn('foo');

        $this->assertTrue($strategy->launch());
    }

    /**
     * @return void
     */
    public function testLaunchUser0p(): void
    {
        $strategy = new UserPercent($this->auth, 0);
        $strategy->setFeature($this->feature);

        $this->auth->shouldReceive('guard->id')->once()->andReturn(1);
        $this->feature->shouldReceive('getName')->once()->andReturn('foo');

        $this->assertFalse($strategy->launch());
    }
}
