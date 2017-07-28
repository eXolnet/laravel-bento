<?php namespace Exolnet\Bento\Strategy;

class Environment extends Strategy
{
    /**
     * @var array
     */
    protected $environments;

    /**
     * @param array|string $environments
     */
    public function __construct($environments)
    {
        $this->environments = (array)$environments;
    }

    /**
     * @return bool
     */
    public function isLaunched()
    {
        $environment = app()->environment();

        return in_array($environment, $this->environments);
    }
}
