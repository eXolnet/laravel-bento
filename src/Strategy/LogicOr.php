<?php namespace Exolnet\Bento\Strategy;

class LogicOr extends Logic
{
    /**
     * @return bool
     */
    public function isLaunched()
    {
        /** @var \Exolnet\Bento\Strategy\Strategy $strategy */
        foreach ($this->strategies as $strategy) {
            if ($strategy->isLaunched()) {
                return true;
            }
        }

        return false;
    }
}
