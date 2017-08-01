<?php namespace Exolnet\Bento\Strategy;

use Illuminate\Support\Str;

abstract class Strategy
{
    /**
     * @return bool
     */
    abstract public function launch();

    /**
     * @param string $name
     * @param array $options
     * @return \Exolnet\Bento\Strategy\Strategy
     */
    public static function make($name, ...$options)
    {
        $className = '\\Exolnet\\Bento\\Strategy\\'. Str::studly($name);

        return new $className(...$options);
    }
}
