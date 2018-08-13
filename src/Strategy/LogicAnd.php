<?php

namespace Exolnet\Bento\Strategy;

class LogicAnd extends Logic
{
    /**
     * @return bool
     */
    public function launch()
    {
        /** @var \Exolnet\Bento\Strategy\Strategy $strategy */
        foreach ($this->strategies as $strategy) {
            if (! $strategy->launch()) {
                return false;
            }
        }

        return true;
    }
}
