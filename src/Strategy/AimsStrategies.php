<?php

namespace Exolnet\Bento\Strategy;

use Exolnet\Bento\Bento;
use Exolnet\Bento\Feature;

abstract class AimsStrategies implements FeatureAware
{
    /**
     * @var \Exolnet\Bento\Bento
     */
    protected $bento;

    /**
     * @var \Exolnet\Bento\Feature
     */
    protected $feature;

    /**
     * @var array<int, \Exolnet\Bento\Strategy\Strategy>
     */
    protected $strategies = [];

    /**
     * @param \Exolnet\Bento\Bento $bento
     * @param \Exolnet\Bento\Feature $feature
     */
    public function __construct(Bento $bento, Feature $feature)
    {
        $this->bento = $bento;
        $this->feature = $feature;
    }

    /**
     * @return \Exolnet\Bento\Feature
     */
    public function getFeature(): Feature
    {
        return $this->feature;
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
     * @param string $strategy
     * @param ...$options
     * @return $this
     */
    public function aim(string $strategy, ...$options): self
    {
        $this->strategies[] = $this->bento->makeStrategy($this->feature, $strategy, ...$options);

        return $this;
    }

    /**
     * @param string $strategy
     * @param array $options
     * @return $this
     */
    public function __call(string $strategy, array $options): self
    {
        return $this->aim($strategy, ...$options);
    }

    /**
     * @return bool
     */
    abstract public function launch(): bool;
}
