<?php namespace Exolnet\Segment\Strategy;

class Percent extends Strategy
{
    /**
     * @var int
     */
    private $percent;

    /**
     * @param int $percent
     */
    public function __construct($percent)
    {
        $this->percent = $percent;
    }

    /**
     * @return bool
     */
    public function isLaunched()
    {
        // TODO-AD: Find a way to launch feature to same users based on the percent <adeschambeault@exolnet.com>
        return false;
    }
}
