<?php namespace Exolnet\Bento\Strategy;

use Exolnet\Bento\Bento;

abstract class Logic extends StrategyContainer
{
    /**
     * @param \Exolnet\Bento\Bento $bento
     * @param callable|null $callback
     */
    public function __construct(Bento $bento, callable $callback = null)
    {
        parent::__construct($bento);

        if ($callback) {
            $callback($this);
        }
    }
}
