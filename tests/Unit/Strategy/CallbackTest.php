<?php

namespace Exolnet\Bento\Tests\Unit\Strategy;

use Exolnet\Bento\Strategy\Callback;
use Exolnet\Bento\Tests\TestCase;
use Generator;
use PHPUnit\Framework\Attributes\DataProvider;

class CallbackTest extends TestCase
{
    /**
     * @return void
     */
    #[DataProvider('provideTestLaunch')]
    public function testLaunch($expected): void
    {
        $strategy = new Callback($this->app, function () use ($expected) {
            return $expected;
        });

        $actual = $strategy->launch();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return \Generator
     */
    public static function provideTestLaunch(): Generator
    {
        yield [true];
        yield [false];
    }
}
