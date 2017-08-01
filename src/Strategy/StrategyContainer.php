<?php namespace Exolnet\Bento\Strategy;

abstract class StrategyContainer
{
    /**
     * @var array
     */
    protected $strategies = [];

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
        $this->strategies[] = Strategy::make($strategy, ...$options);

        return $this;
    }

    /**
     * @return bool
     */
    abstract public function launch();
}
