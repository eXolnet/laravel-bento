<?php namespace Exolnet\Segment\Strategy;

class Nobody extends Strategy
{
    /**
     * @return bool
     */
    public function isLaunched()
    {
        return false;
    }
}
