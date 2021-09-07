<?php

namespace Exolnet\Bento;

use Exolnet\Bento\Strategy\All as AllStrategy;

class Feature extends AllStrategy
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        parent::__construct();

        $this->feature = $this;
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function launch(): bool
    {
        if (! $this->hasStrategies()) {
            return false;
        }

        return parent::launch();
    }
}
