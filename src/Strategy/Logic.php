<?php namespace Exolnet\Bento\Strategy;

abstract class Logic extends StrategyContainer
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
}
