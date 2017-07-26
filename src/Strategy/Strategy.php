<?php namespace Exolnet\Segment\Strategy;

use Illuminate\Support\Str;

abstract class Strategy
{
    /**
     * @return bool
     */
    abstract public function isLaunched();

    /**
     * @param string $name
     * @param array $options
     * @return \Exolnet\Segment\Strategy\Strategy
     */
    public static function make($name, ...$options)
    {
        $className = '\\Exolnet\\Segment\\Strategy\\'. Str::studly($name);

        return new $className(...$options);
    }
}
