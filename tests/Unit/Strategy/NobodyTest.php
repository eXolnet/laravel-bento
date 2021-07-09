<?php

namespace Exolnet\Bento\Tests\Unit\Strategy;

use Exolnet\Bento\Strategy\Nobody;
use Exolnet\Bento\Tests\UnitTest;

class NobodyTest extends UnitTest
{
    /**
     * @return void
     * @test
     */
    public function testLaunch(): void
    {
        $strategy = new Nobody();

        $this->assertFalse($strategy->launch());
    }
}
