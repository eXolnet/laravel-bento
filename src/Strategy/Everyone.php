<?php namespace Exolnet\Bento\Strategy;

class Everyone extends Strategy
{
    /**
     * @return bool
     */
    public function launch()
    {
        return true;
    }
}
