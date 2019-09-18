<?php

namespace Exolnet\Bento\Strategy;

class Custom extends Strategy
{
    /**
     * @var callable
     */
    protected $callback;

    /**
     * @var array
     */
    protected $options;

    /**
     * @param callable $callback
     * @param array $options
     */
    public function __construct(callable $callback, array $options = [])
    {
        $this->callback = $callback;
        $this->options = $options;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @return bool
     */
    public function launch(): bool
    {
        return call_user_func($this->callback, $this->options);
    }
}
