<?php

namespace Exolnet\Bento\Tests\Feature;

use Exolnet\Bento\Bento;
use Exolnet\Bento\Tests\TestCase;

class BentoTest extends TestCase
{
    /**
     * @return void
     */
    public function testIsSingleton(): void
    {
        $instance1 = $this->app->make(Bento::class);
        $instance2 = $this->app->make(Bento::class);

        $this->assertSame($instance1, $instance2);
    }

    /**
     * @return void
     */
    public function testAlias(): void
    {
        $instance = $this->app->make(Bento::class);
        $alias    = $this->app->make('bento');

        $this->assertSame($instance, $alias);
    }

    /**
     * @return void
     */
    public function testSetVisitorId(): void
    {
        $instance = $this->app->make(Bento::class);
        $instance->setVisitorId(1234);

        $this->assertEquals(1234, $instance->getVisitorId());
    }

    /**
     * @return void
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
     */
    public function testAwaitWithEveryoneStrategy(): void
    {
        /** @var \Exolnet\Bento\Bento $instance */
        $instance = $this->app->make(Bento::class);
        $instance->feature('foo')->everyone();

        $this->assertFalse($instance->await('foo'));
    }
}
