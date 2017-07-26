<?php namespace Exolnet\Bento;

use Exolnet\Bento\Strategy\Strategy;

class Feature
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
    public function isLaunched()
    {
        if (empty($this->strategies)) {
            return false;
        }

        /** @var \Exolnet\Bento\Strategy\Strategy $strategy */
        foreach ($this->strategies as $strategy) {
            if ( ! $strategy->isLaunched()) {
                return false;
            }
        }

        return true;
    }
}
