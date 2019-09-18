<?php

namespace Exolnet\Bento\Tests\Unit\Strategy;

use Exolnet\Bento\Strategy\Everyone;
use Exolnet\Bento\Tests\UnitTest;

class EveryoneTest extends UnitTest
{
    /**
     * @return void
     */
    public function testLaunch(): void
    {
        $strategy = new Everyone();

        $this->assertTrue($strategy->launch());
    }
}
