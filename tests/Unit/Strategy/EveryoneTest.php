<?php

namespace Exolnet\Bento\Tests\Unit\Strategy;

use Exolnet\Bento\Strategy\Everyone;
use Exolnet\Bento\Tests\TestCase;

class EveryoneTest extends TestCase
{
    /**
     * @return void
     * @test
     */
    public function testLaunch(): void
    {
        $strategy = new Everyone();

        $this->assertTrue($strategy->launch());
    }
}
