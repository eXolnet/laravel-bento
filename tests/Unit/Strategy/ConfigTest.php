<?php

namespace Exolnet\Bento\Tests\Unit\Strategy;

use Exolnet\Bento\Strategy\Config;
use Exolnet\Bento\Tests\UnitTest;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Mockery as m;

class ConfigTest extends UnitTest
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

        $this->config = m::mock(ConfigRepository::class);
    }

    /**
     * @return void
     * @dataProvider provideTestLaunch
     */
    public function testLaunch($expected): void
    {
        $strategy = new Config($this->config, 'feature.key');

        $this->config->shouldReceive('get')->with('feature.key')->once()->andReturn($expected);

        $actual = $strategy->launch();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return array
     */
    public function provideTestLaunch(): array
    {
        return [
            [true],
            [false],
        ];
    }
}
