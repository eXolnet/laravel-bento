<?php

namespace Exolnet\Bento\Tests\Unit\Strategy;

use Exolnet\Bento\Strategy\Environment;
use Exolnet\Bento\Tests\TestCase;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Mockery;

class EnvironmentTest extends TestCase
{
    /**
     * @var \Illuminate\Contracts\Config\Repository
     */
    protected $config;

    /**
     * @var \Exolnet\Bento\Strategy\Environment
     */
    protected $strategy;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->config = Mockery::mock(ConfigRepository::class);

        $this->strategy = new Environment($this->config, ['testing']);
    }

    /**
     * @return void
     * @test
     */
    public function testLaunch(): void
    {
        $this->config->shouldReceive('get')->once()->andReturn('testing');

        $this->assertTrue($this->strategy->launch());
    }
}
