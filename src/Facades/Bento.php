<?php

namespace Exolnet\Bento\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Exolnet\Bento\Bento
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
