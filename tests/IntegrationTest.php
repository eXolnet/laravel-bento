<?php

namespace Exolnet\Bento\Tests;

use Exolnet\Bento\BentoServiceProvider;
use Orchestra\Testbench\TestCase;

abstract class IntegrationTest extends TestCase
{
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
