<?php

namespace Exolnet\Bento\Tests\Unit;

use Exolnet\Bento\Bento;
use Exolnet\Bento\Feature;
use Exolnet\Bento\Tests\TestCase;
use Illuminate\Http\Request;
use Mockery;

class BentoTest extends TestCase
{
    /**
     * @var \Exolnet\Bento\Bento
     */
    protected $bento;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->bento = new Bento();
    }

    /**
     * @return void
     */
    public function testInitializeFeature(): void
    {
        $feature = $this->bento->feature('foo');

        $this->assertInstanceOf(Feature::class, $feature);
        $this->assertEquals('foo', $feature->getName());
    }

    /**
     * @return void
     */
    public function testLaunch(): void
    {
        $this->bento->feature('foo')->everyone();
        $this->assertTrue($this->bento->launch('foo'));

        $this->bento->feature('bar')->nobody();
        $this->assertFalse($this->bento->launch('bar'));
    }

    /**
     * @return void
     */
    public function testAwait(): void
    {
        $this->bento->feature('foo')->everyone();
        $this->assertFalse($this->bento->await('foo'));

        $this->bento->feature('bar')->nobody();
        $this->assertTrue($this->bento->await('bar'));
    }

    /**
     * @return void
     */
    public function testSetVisitorId(): void
    {
        $this->bento->setVisitorId(42);

        $this->assertEquals(42, $this->bento->getVisitorId());
    }

    /**
     * @return void
     */
    public function testMakeVisitorId(): void
    {
        $request = Mockery::mock(Request::class);

        $request->shouldReceive('setUserResolver');
        $request->shouldReceive('ip')->andReturn('127.0.0.1');
        $request->shouldReceive('header')->with('user-agent')->andReturn('Chrome');

        $this->instance('request', $request);

        $expectedVisitorId = crc32('127.0.0.1Chrome');

        $this->assertEquals($expectedVisitorId, $this->bento->getVisitorId());
    }
}
