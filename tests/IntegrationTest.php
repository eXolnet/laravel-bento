<?php

namespace Exolnet\Bento\Tests;

use Exolnet\Bento\BentoServiceProvider;
use Exolnet\Bento\Strategy\Date;
use Orchestra\Testbench\TestCase;

abstract class IntegrationTest extends TestCase
{
    /**
     * @return void
     */
    public function tearDown(): void
    {
        Date::setNow(null);
    }

    /**
     * Get the service providers for the package.
     *
     * @param  \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app): array
    {
        return [BentoServiceProvider::class];
    }
}
