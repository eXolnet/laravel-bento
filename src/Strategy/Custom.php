<?php namespace Exolnet\Bento\Strategy;

class Custom extends Strategy
{
    /**
     * @var callable
     */
    protected $callback;

    /**
     * @param callable $callback
     */
    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    /**
     * @return bool
     */
    public function launch()
    {
        return call_user_func($this->callback);
    }
}
