<?php

namespace Exolnet\Bento\Tests\Integration;

use Exolnet\Bento\Bento;
use Exolnet\Bento\Tests\IntegrationTest;

class BentoTest extends IntegrationTest
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
    public function testMakeVisitorIdWithLocalHost(): void
    {
        $instance = $this->app->make(Bento::class);

        $requestIp = request()->ip();
        $requestHeader = request()->header('user-agent');

        $this->assertEquals("127.0.0.1", $requestIp);
        $this->assertEquals("Symfony", $requestHeader);
        //crc32 of 127.0.0.1Symphony
        $this->assertEquals(736005061, crc32($requestIp . $requestHeader));
    }

    /**
     * @return void
     */
    public function testGetVisitorIdWhenNoVisitorId(): void
    {
        $instance = $this->app->make(Bento::class);

        //736005061 =crc32(127.0.0.1Symphony)
        $this->assertEquals(736005061, crc32('127.0.0.1Symfony'));
        $this->assertEquals(736005061, $instance->getVisitorId());
    }


}
