<?php

namespace Exolnet\Bento;

use Exolnet\Bento\Strategy\Strategy;

class Bento
{
    /**
     * @var \Exolnet\Bento\StrategyFactory
     */
    protected $factory;

    /**
     * @var array
     */
    protected $features = [];

    /**
     * @var int
     */
    protected $visitorId;

    /**
     * @param \Exolnet\Bento\StrategyFactory $factory
     */
    public function __construct(StrategyFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @param string $name
     * @return \Exolnet\Bento\Feature
     */
    public function feature(string $name): Feature
    {
        if (! isset($this->features[$name])) {
            $this->features[$name] = new Feature($this, $name);
        }

        return $this->features[$name];
    }

    /**
     * @param string $name
     * @param string $strategy
     * @param ...$options
     * @return \Exolnet\Bento\Feature
     */
    public function aim(string $name, string $strategy, ...$options): Feature
    {
        return $this->feature($name)->aim($strategy, ...$options);
    }

    /**
     * @param string $name
     * @return bool
     */
    public function launch(string $name): bool
    {
        return $this->feature($name)->launch();
    }

    /**
     * @param string $name
     * @return bool
     */
    public function await(string $name): bool
    {
        return ! $this->launch($name);
    }

    /**
     * @return int
     */
    public function getVisitorId(): int
    {
        if (! $this->visitorId) {
            $this->visitorId = $this->makeVisitorId();
        }

        return $this->visitorId;
    }

    /**
     * @param int $visitorId
     * @return $this
     */
    public function setVisitorId(int $visitorId)
    {
        $this->visitorId = $visitorId;

        return $this;
    }

    /**
     * @return int
     */
    protected function makeVisitorId(): int
    {
        $request = request();

        return crc32($request->ip() . $request->header('user-agent'));
    }

    /**
     * @param \Exolnet\Bento\Feature $feature
     * @param string $name
     * @param ...$options
     * @return \Exolnet\Bento\Strategy\Strategy
     * @throws \ReflectionException
     */
    public function makeStrategy(Feature $feature, string $name, ...$options)
    {
        return $this->factory->make($feature, $name, ...$options);
    }

    /**
     * @param string $name
     * @param callable $callback
     * @return $this
     */
    public function defineStrategy(string $name, callable $callback): self
    {
        $this->factory->register($name, $callback);

        return $this;
    }
}
