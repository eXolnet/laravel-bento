<?php namespace Exolnet\Bento\Strategy;

use Illuminate\Foundation\Application;

class Environment extends Strategy
{
    /**
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * @var array
     */
    protected $environments;

    /**
     * @param \Illuminate\Foundation\Application $app
     * @param array|string $environments
     */
    public function __construct(Application $app, $environments)
    {
        $this->app = $app;
        $this->environments = (array)$environments;
    }

    /**
     * @return bool
     */
    public function launch()
    {
        $environment = $this->app->environment();

        return in_array($environment, $this->environments);
    }
}
