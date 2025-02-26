<?php

namespace Exolnet\Bento\Tests\Feature;

use Exolnet\Bento\Facades\Bento;
use Exolnet\Bento\Tests\TestCase;
use Generator;
use Illuminate\Contracts\View\Factory;
use PHPUnit\Framework\Attributes\DataProvider;

class BladeTest extends TestCase
{
    /**
     * @param string $directive
     * @param bool $state
     * @return void
     */
    #[DataProvider('provideTestDirective')]
    public function testDirective(string $directive, bool $state): void
    {
        Bento::feature('foo')->stub($state);

        $view = app(Factory::class)->file(__DIR__ . '/../Fixtures/' . $directive . '.blade.php');
        $html = $view->render();

        $expected = $state ? 'Launch' : 'Await';
        $this->assertStringContainsStringIgnoringCase($expected, $html);
        $this->assertStringNotContainsStringIgnoringCase('@', $html);
    }

    /**
     * @return \Generator
     */
    public static function provideTestDirective(): Generator
    {
        yield ['launch', true];
        yield ['launch', false];
        yield ['await', true];
        yield ['await', false];
    }
}
