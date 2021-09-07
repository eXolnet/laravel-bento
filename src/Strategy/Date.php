<?php

namespace Exolnet\Bento\Strategy;

use Illuminate\Support\Carbon;
use InvalidArgumentException;

class Date implements Strategy
{
    /**
     * @var \Illuminate\Support\Carbon
     */
    protected static $now;

    /**
     * @var \Illuminate\Support\Carbon
     */
    protected $date;

    /**
     * @var string
     */
    protected $operator;

    /**
     * @param \DateTime|string|int $date
     * @param string $operator
     */
    public function __construct($date, string $operator = '>=')
    {
        $this->date = Carbon::parse($date);
        $this->operator = $operator;
    }

    /**
     * @return bool
     */
    public function launch(): bool
    {
        $now = static::getNow();

        if ($this->operator === '<') {
            return $now->gt($this->date);
        } elseif ($this->operator === '<=') {
            return $now->gte($this->date);
        } elseif ($this->operator === '>=') {
            return $now->lte($this->date);
        } elseif ($this->operator === '>') {
            return $now->lt($this->date);
        } elseif ($this->operator === '=') {
            return $now->eq($this->date);
        }

        throw new InvalidArgumentException(
            'Invalid '. $this->operator .' operator for strategy '. static::class
        );
    }

    /**
     * @return \Illuminate\Support\Carbon
     */
    protected static function getNow(): Carbon
    {
        if (! static::$now) {
            static::$now = Carbon::now();
        }

        return static::$now;
    }

    /**
     * @param \Illuminate\Support\Carbon $now
     */
    public static function setNow(?Carbon $now): void
    {
        static::$now = $now;
    }
}
