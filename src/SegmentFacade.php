<?php namespace Exolnet\Segment;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Exolnet\Segment\Segment
 */
class SegmentFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'segment';
    }
}
