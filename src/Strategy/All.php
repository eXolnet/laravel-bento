<?php

namespace Exolnet\Bento\Strategy;

class All extends LogicGroup
{
    /**
     * @return bool
     */
    public function launch(): bool
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
