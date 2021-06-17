<?php

namespace Exolnet\Bento\Tests\Integration;

use Exolnet\Bento\Bento;
use Exolnet\Bento\Feature;
use Exolnet\Bento\Tests\IntegrationTest;

class BentoTest extends IntegrationTest
{
    /**
     * @return void
     * @test
     */
    public function testIsSingleton(): void
    {
        $instance1 = $this->app->make(Bento::class);
        $instance2 = $this->app->make(Bento::class);

        $this->assertSame($instance1, $instance2);
    }

    /**
     * @return void
     * @test
     */
    public function testAlias(): void
    {
        $instance = $this->app->make(Bento::class);
        $alias    = $this->app->make('bento');

        $this->assertSame($instance, $alias);
    }

    /**
     * @return void
     * @test
     */
    public function testSetVisitorId(): void
    {
        $instance = $this->app->make(Bento::class);
        $instance->setVisitorId(1234);

        $this->assertEquals(1234, $instance->getVisitorId());
    }

    /**
     * @return void
     * @test
     */
    public function testGetVisitorIdWhenNoVisitorId(): void
    {
        $instance = $this->app->make(Bento::class);

        $ip = request()->ip();
        $header = request()->header('user-agent');

        $this->assertEquals(crc32($ip . $header), $instance->getVisitorId());
    }

    /**
     * @return void
     * @test
     */
    public function testAwaitWithEveryoneStrategy(): void
    {
        $instance = $this->app->make(Bento::class);
        $instance->feature('foo')->aim('everyone');

        self::assertFalse($instance->await('foo'));
    }
}
