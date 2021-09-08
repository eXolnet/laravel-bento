<?php

namespace Exolnet\Bento\Tests\Unit\Strategy;

use Exolnet\Bento\Strategy\Stub;
use Exolnet\Bento\Tests\TestCase;

class StubTest extends TestCase
{
    /**
     * @return void
     * @test
     */
    public function testLaunchTrue(): void
    {
        $strategy = new Stub(true);

        $this->assertTrue($strategy->launch());
    }

    /**
     * @return void
     * @test
     */
    public function testLaunchFalse(): void
    {
        $strategy = new Stub(false);

        $this->assertFalse($strategy->launch());
    }
}
