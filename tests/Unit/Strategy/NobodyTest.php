<?php

namespace Exolnet\Bento\Tests\Unit\Strategy;

use Exolnet\Bento\Strategy\Nobody;
use Exolnet\Bento\Tests\TestCase;

class NobodyTest extends TestCase
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
