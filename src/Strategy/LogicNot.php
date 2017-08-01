<?php namespace Exolnet\Bento\Strategy;

class LogicNot extends Strategy
{
    /**
     * @var \Exolnet\Bento\Strategy\Strategy
     */
    protected $strategy;

    /**
     * @param $name
     * @param array ...$options
     */
    public function __construct($name, ...$options)
    {
        $this->strategy = Strategy::make($name, ...$options);
    }

    /**
     * @return bool
     */
    public function launch()
    {
        return ! $this->strategy->launch();
    }
}
