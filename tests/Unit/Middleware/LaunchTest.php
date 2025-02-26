<?php

namespace Exolnet\Bento\Tests\Unit\Middleware;

use Exolnet\Bento\Bento;
use Exolnet\Bento\Middleware\Launch;
use Exolnet\Bento\Tests\TestCase;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Mockery;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LaunchTest extends TestCase
{
    /**
     * @var \Exolnet\Bento\Bento|\Mockery\MockInterface
     */
    protected $bento;

    /**
     * @var \Illuminate\Http\Request|\Mockery\MockInterface
     */
    protected $request;

    /**
     * @var \Exolnet\Bento\Middleware\Launch
     */
    protected $middleware;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->bento = Mockery::mock(Bento::class);
        $this->request = Mockery::mock(Request::class);

        $this->middleware = new Launch($this->bento);
    }

    /**
     * @return void
     */
    public function testFeatureLaunched(): void
    {
        $this->bento->shouldReceive('launch')->once()->with('feature')->andReturn(true);

        $responseExpected = Mockery::mock(Response::class);

        $next = function (...$arguments) use ($responseExpected) {
            $this->assertCount(1, $arguments);
            $this->assertEquals($this->request, $arguments[0]);

            return $responseExpected;
        };

        $responseActual = $this->middleware->handle($this->request, $next, 'feature');

        $this->assertEquals($responseExpected, $responseActual);
    }

    /**
     * @return void
     */
    public function testFeatureNotLaunched(): void
    {
        $this->bento->shouldReceive('launch')->once()->with('feature')->andReturn(false);

        $next = function () {
            // The next method should not be called
            $this->assertFalse(true);
        };

        $this->expectException(NotFoundHttpException::class);

        $this->middleware->handle($this->request, $next, 'feature');
    }
}
