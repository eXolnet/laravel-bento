<?php

namespace Exolnet\Bento;

use Exolnet\Bento\Strategy\LogicAnd;

class Feature extends LogicAnd
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @param \Exolnet\Bento\Bento $bento
     * @param callable|null $name
     */
    public function __construct(Bento $bento, $name)
    {
        parent::__construct($bento, $this);

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
