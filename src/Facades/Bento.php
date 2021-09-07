<?php

namespace Exolnet\Bento\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Exolnet\Bento\Bento
 *
 * @method static \Exolnet\Bento\Feature feature(string $name)
 * @method static bool launch(string $name)
 * @method static bool await(string $name)
 * @method static int getVisitorId()
 * @method static \Exolnet\Bento\Bento setVisitorId(int $visitorId)
 */
class Bento extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'bento';
    }
}
