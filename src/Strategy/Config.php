<?php

namespace Exolnet\Bento\Strategy;

use Illuminate\Contracts\Config\Repository as ConfigRepository;

class Config implements Strategy
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
    public function __construct(ConfigRepository $config, string $key)
    {
        $this->config = $config;
        $this->key = $key;
    }

    /**
     * @return bool
     */
    public function launch(): bool
    {
        return (bool)$this->config->get($this->key);
    }
}
