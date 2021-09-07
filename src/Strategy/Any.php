<?php

namespace Exolnet\Bento\Strategy;

class Any extends Logic
{
    /**
     * @return bool
     */
    public function launch(): bool
    {
        /** @var \Exolnet\Bento\Strategy\Strategy $strategy */
        foreach ($this->strategies as $strategy) {
            if ($strategy->launch()) {
                return true;
            }
        }

        return false;
    }
}
