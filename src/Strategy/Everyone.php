<?php namespace Exolnet\Segment\Strategy;

class Everyone extends Strategy
{
    /**
     * @return bool
     */
    public function isLaunched()
    {
        return true;
    }
}
