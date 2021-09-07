<?php

namespace Exolnet\Bento\Strategy;

use Exolnet\Bento\Bento;
use Exolnet\Bento\Feature;

abstract class Logic extends AimsStrategies implements Strategy
{
    /**
     * @param \Exolnet\Bento\Bento $bento
     * @param \Exolnet\Bento\Feature $feature
     * @param callable|null $callback
     */
    public function __construct(Bento $bento, Feature $feature, callable $callback = null)
    {
        parent::__construct($bento, $feature);

        if ($callback) {
            $callback($this);
        }
    }
}
