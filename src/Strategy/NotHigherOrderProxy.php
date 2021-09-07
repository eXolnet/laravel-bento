<?php

namespace Exolnet\Bento\Strategy;

class NotHigherOrderProxy extends AimsStrategy
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
     * @param \Exolnet\Bento\Strategy\Strategy|string $strategy
     * @param mixed ...$parameters
     * @return \Exolnet\Bento\Strategy\AimsStrategy
     */
    public function aim($strategy, ...$parameters)
    {
        return $this->aims->not($strategy, ...$parameters);
    }
}
