<?php

namespace Exolnet\Bento\Tests;

use Mockery;
use PHPUnit\Framework\TestCase;

abstract class UnitTest extends TestCase
{
    /**
     * @return void
     */
    public function tearDown(): void
    {
        Mockery::close();
    }
}
