<?php

namespace Exolnet\Bento\Strategy;

use Carbon\Carbon;

class Date extends Strategy
{
    /**
     * @var \Carbon\Carbon
     */
    protected static $now;

    /**
     * @var \Carbon\Carbon
     */
    protected $date;

    /**
     * @var string
     */
    protected $operator;

    /**
     * @param string|int $date
     * @param string $operator
     */
    public function __construct($date, $operator = '>=')
    {
        $this->date = Carbon::parse($date);
        $this->operator = $operator;
    }

    /**
     * @return bool
     */
    public function launch()
    {
        $now = static::getNow();

        if ($this->operator === '<') {
            return $now->startOfDay()->gt($this->date);
        } elseif ($this->operator === '<=') {
            return $now->startOfDay()->gte($this->date);
        } elseif ($this->operator === '>=') {
            return $now->endOfDay()->lte($this->date);
        } elseif ($this->operator === '>') {
            return $now->endOfDay()->lt($this->date);
        } elseif ($this->operator === '=') {
            return $now->endOfDay()->isSameDay($this->date);
        }

        return false;
    }

    /**
     * @return \Carbon\Carbon
     */
    protected static function getNow()
    {
        if (! static::$now) {
            static::$now = Carbon::now();
        }

        return static::$now;
    }
}
