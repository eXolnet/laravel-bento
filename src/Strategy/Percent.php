<?php

namespace Exolnet\Bento\Strategy;

use Exolnet\Bento\Feature;

abstract class Percent implements FeatureAwareStrategy, Strategy
{
    /**
     * @var int
     */
    protected $percent;

    /**
     * @var \Exolnet\Bento\Feature|null
     */
    protected $feature;

    /**
     * @param int $percent
     */
    public function __construct(int $percent)
    {
        $this->percent = $percent;
    }

    /**
     * @param  \Exolnet\Bento\Feature $feature
     * @return void
     */
    public function setFeature(Feature $feature): void
    {
        $this->feature = $feature;
    }

    /**
     * @return int
     */
    public function getPercent(): int
    {
        return $this->percent;
    }

    /**
     * @return int|null
     */
    abstract public function getUniqueId(): ?int;

    /**
     * @return bool
     */
    public function launch(): bool
    {
        if (! $uniqueId = $this->getUniqueId()) {
            return false;
        }

        $uniqueNumber = crc32($this->feature->getName() . '|' . $uniqueId);

        // Limit the unique ID between 1 and 100.
        $percentile = $uniqueNumber % 100 + 1;

        // Based on the calculated percentile, we identify if the user has access to the feature.
        return $percentile <= $this->percent;
    }
}
