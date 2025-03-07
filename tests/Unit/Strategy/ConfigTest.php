<?php

namespace Exolnet\Bento\Tests\Unit\Strategy;

use Exolnet\Bento\Strategy\Config;
use Exolnet\Bento\Tests\TestCase;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Mockery;
use PHPUnit\Framework\Attributes\DataProvider;

class ConfigTest extends TestCase
{
    /**
     * @var \Illuminate\Contracts\Config\Repository|\Mockery\MockInterface
     */
    protected $config;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->config = Mockery::mock(ConfigRepository::class);
    }

    /**
     * @param bool $expected
     * @return void
     */
    #[DataProvider('provideTestLaunch')]
    public function testLaunch(bool $expected): void
    {
        $strategy = new Config($this->config, 'feature.key');

        $this->config->shouldReceive('get')->with('feature.key')->once()->andReturn($expected);

        $actual = $strategy->launch();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return array
     */
    public static function provideTestLaunch(): array
    {
        return [
            [true],
            [false],
        ];
    }
}
