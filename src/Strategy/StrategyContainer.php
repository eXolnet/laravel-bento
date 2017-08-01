<?php namespace Exolnet\Bento\Strategy;

use Exolnet\Bento\BentoFacade;

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
        $this->strategies[] = BentoFacade::makeStrategy($strategy, ...$options);

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
