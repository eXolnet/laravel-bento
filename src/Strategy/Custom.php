<?php namespace Exolnet\Bento\Strategy;

class Custom extends Strategy
{
    /**
     * @var callable
     */
    protected $callback;
    /**
     * @var array
     */
    private $options;

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
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @return bool
     */
    public function launch()
    {
        return call_user_func($this->callback, $this->options);
    }
}
