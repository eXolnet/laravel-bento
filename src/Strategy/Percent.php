<?php namespace Exolnet\Bento\Strategy;

abstract class Percent extends Strategy
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
     * @return int
     */
    abstract public function getUniqueId();

    /**
     * @return bool
     */
    public function launch()
    {
        // Limit the unique ID between 1 and 100.
        $percentile = $this->getUniqueId() % 100 + 1;

        // Based on the calculated percentile, we identify if the user has access to the feature.
        return $percentile <= $this->percent;
    }
}
