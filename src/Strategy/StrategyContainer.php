<?php namespace Exolnet\Bento\Strategy;

use Exolnet\Bento\Bento;
use Exolnet\Bento\Feature;

abstract class StrategyContainer implements FeatureAware
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
     * @var array
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
    public function getFeature()
    {
        return $this->feature;
    }

    /**
     * @return array
     */
    public function getStrategies()
    {
        return $this->strategies;
    }

    /**
     * @return int
     */
    public function countStrategies()
    {
        return count($this->strategies);
    }

    /**
     * @return bool
     */
    public function hasStrategies()
    {
        return $this->countStrategies() > 0;
    }

    /**
     * @param string $strategy
     * @param array ...$options
     * @return $this
     */
    public function aim($strategy, ...$options)
    {
        $this->strategies[] = $this->bento->makeStrategy($this->feature, $strategy, ...$options);

        return $this;
    }

    /**
     * @param string $strategy
     * @param array $options
     * @return \Exolnet\Bento\Strategy\StrategyContainer
     */
    public function __call($strategy, array $options)
    {
        return $this->aim($strategy, ...$options);
    }

    /**
     * @return bool
     */
    abstract public function launch();
}
