<?php namespace Exolnet\Bento;

use Exolnet\Bento\Strategy\Custom;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Str;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionFunction;

class StrategyFactory
{
    use StrategyDependencyResolverTrait;

    /**
     * @var \Illuminate\Contracts\Container\Container
     */
    protected $container;

    /**
     * @var array
     */
    protected $customStrategies = [];

    /**
     * @param \Illuminate\Contracts\Container\Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param \Exolnet\Bento\Feature $feature
     * @param string $name
     * @param array $parameters
     * @return \Exolnet\Bento\Strategy\Strategy
     */
    public function make(Feature $feature, $name, ...$parameters)
    {
        if (isset($this->customStrategies[$name])) {
            return $this->makeCustom($feature, $name, $parameters);
        }

        return $this->makeClass($feature, $name, $parameters);
    }

    /**
     * @param \Exolnet\Bento\Feature $feature
     * @param string $name
     * @param array $parameters
     * @return \Exolnet\Bento\Strategy\Custom
     */
    protected function makeCustom(Feature $feature, $name, array $parameters)
    {
        $customStrategy = $this->customStrategies[$name];

        $closure = new ReflectionFunction($customStrategy);
        $parameters = $this->resolveMethodDependencies($feature, $parameters, $closure);

        return new Custom($customStrategy, $parameters);
    }

    /**
     * @param \Exolnet\Bento\Feature $feature
     * @param string $name
     * @param array $parameters
     * @return \Exolnet\Bento\Strategy\Strategy
     */
    protected function makeClass(Feature $feature, $name, array $parameters)
    {
        $className = '\\Exolnet\\Bento\\Strategy\\'. Str::studly($name);

        if (! class_exists($className)) {
            throw new InvalidArgumentException('Could not instantiate strategy with name '. $name);
        }

        $constructor = (new ReflectionClass($className))->getConstructor();

        if ($constructor) {
            $parameters = $this->resolveMethodDependencies($feature, $parameters, $constructor);
        }

        return new $className(...$parameters);
    }

    /**
     * @param string $name
     * @param callable $callback
     * @return $this
     */
    public function register($name, callable $callback)
    {
        $this->customStrategies[$name] = $callback;

        return $this;
    }
}
