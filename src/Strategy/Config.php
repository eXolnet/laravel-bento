<?php namespace Exolnet\Bento\Strategy;

use \Illuminate\Contracts\Config\Repository as ConfigRepository;

class Config extends Strategy
{
    /**
     * @var \Illuminate\Contracts\Config\Repository
     */
    protected $config;

    /**
     * @var string
     */
    protected $key;

    /**
     * @param \Illuminate\Contracts\Config\Repository $config
     * @param string $key
     */
    public function __construct(ConfigRepository $config, $key)
    {
        $this->config = $config;
        $this->key = $key;
    }

    /**
     * @return bool
     */
    public function launch()
    {
        return $this->config->get($this->key);
    }
}
