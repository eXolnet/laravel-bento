<?php

namespace Exolnet\Bento\Strategy;

use Exolnet\Bento\Feature;

abstract class AimsStrategies extends AimsStrategy
{
    /**
     * @var array<int, \Exolnet\Bento\Strategy\Strategy>
     */
    protected $strategies = [];

    /**
     * @param \Exolnet\Bento\Feature $feature
     * @return void
     */
    public function setFeature(Feature $feature): void
    {
        parent::setFeature($feature);

        foreach ($this->strategies as $strategy) {
            if ($strategy instanceof FeatureAwareStrategy) {
                $strategy->setFeature($strategy);
            }
        }
    }

    /**
     * @return array<int, \Exolnet\Bento\Strategy\Strategy>
     */
    public function getStrategies(): array
    {
        return $this->strategies;
    }

    /**
     * @return int
     */
    public function countStrategies(): int
    {
        return count($this->strategies);
    }

    /**
     * @return bool
     */
    public function hasStrategies(): bool
    {
        return $this->countStrategies() > 0;
    }

    /**
     * @param \Exolnet\Bento\Strategy\Strategy|string $strategy
     * @param ...$parameters
     * @return $this
     */
    public function aim($strategy, ...$parameters): self
    {
        $this->strategies[] = $strategy = $this->makeStrategy($strategy, $parameters);

        if ($this->feature && $strategy instanceof FeatureAwareStrategy) {
            $strategy->setFeature($this->feature);
        }

        return $this;
    }
}
