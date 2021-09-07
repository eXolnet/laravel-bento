<?php

namespace Exolnet\Bento\Strategy;

class HigherOrderNotProxy extends AimsStrategy
{
    /**
     * @var \Exolnet\Bento\Strategy\AimsStrategies
     */
    protected $aims;

    /**
     * Create a new proxy instance.
     *
     * \Exolnet\Bento\Strategy\AimsStrategy $aims
     */
    public function __construct(AimsStrategy $aims)
    {
        $this->aims = $aims;
    }

    /**
     * @param string $strategy
     * @param mixed ...$options
     * @return \Exolnet\Bento\Strategy\AimsStrategy
     */
    public function aim(string $strategy, ...$options)
    {
        return $this->aims->not($strategy, ...$options);
    }
}
