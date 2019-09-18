<?php

namespace Exolnet\Bento\Strategy;

use Exolnet\Bento\Feature;

abstract class Percent extends Strategy
{
    /**
     * @var int
     */
    protected $percent;

    /**
     * @var \Exolnet\Bento\Feature
     */
    protected $feature;

    /**
     * @param \Exolnet\Bento\Feature $feature
     * @param int $percent
     */
    public function __construct(Feature $feature, $percent)
    {
        $this->feature = $feature;
        $this->percent = $percent;
    }

    /**
     * @return \eXolnet\Bento\Feature
     */
    public function getFeature()
    {
        return $this->feature;
    }

    /**
     * @return int
     */
    public function getPercent()
    {
        return $this->percent;
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
        if (! $uniqueId = $this->getUniqueId()) {
            return false;
        }

        $uniqueNumber = crc32($this->feature->getName() .'|'. $uniqueId);

        // Limit the unique ID between 1 and 100.
        $percentile = $uniqueNumber % 100 + 1;

        // Based on the calculated percentile, we identify if the user has access to the feature.
        return $percentile <= $this->percent;
    }
}
