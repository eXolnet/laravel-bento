<?php namespace Exolnet\Bento;

use Illuminate\Support\Collection;

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
    public function feature($name)
    {
        if (! isset($this->features[$name])) {
            $this->features[$name] = new Feature();
        }

        return $this->features[$name];
    }

    /**
     * @param string $name
     * @param string $strategy
     * @param array ...$options
     * @return \Exolnet\Bento\Feature
     */
    public function aim($name, $strategy, ...$options)
    {
        return $this->feature($name)->aim($strategy, ...$options);
    }

    /**
     * @param string $name
     * @return bool
     */
    public function launch($name)
    {
        return $this->feature($name)->launch();
    }

    /**
     * @return string
     */
    public function getVisitorId()
    {
        if (! $this->visitorId) {
            $this->visitorId = $this->makeVisitorId();
        }

        return $this->visitorId;
    }

    /**
     * @param string $visitorId
     * @return $this
     */
    public function setVisitorId($visitorId)
    {
        $this->visitorId = $visitorId;

        return $this;
    }

    /**
     * @return int
     */
    protected function makeVisitorId()
    {
        $request = request();

        return crc32($request->ip() . $request->header('user-agent'));
    }

    /**
     * @param string $name
     * @param array ...$options
     * @return \Exolnet\Bento\Strategy\Strategy
     */
    public function makeStrategy($name, ...$options)
    {
        return $this->factory->make($name, ...$options);
    }

    /**
     * @param string $name
     * @param callable $callback
     * @return $this
     */
    public function defineStrategy($name, callable $callback)
    {
        $this->factory->register($name, $callback);

        return $this;
    }
}
