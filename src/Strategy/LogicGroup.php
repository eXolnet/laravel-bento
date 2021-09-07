<?php

namespace Exolnet\Bento\Strategy;

abstract class LogicGroup extends AimsStrategies implements Strategy
{
    /**
     * @param callable|null $callback
     */
    public function __construct(callable $callback = null)
    {
        if ($callback) {
            $callback($this);
        }
    }

    /**
     * @return bool
     */
    public function await(): bool
    {
        return ! $this->launch();
    }

    /**
     * @return bool
     */
    abstract public function launch(): bool;
}
