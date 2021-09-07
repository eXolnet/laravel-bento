<?php

namespace Exolnet\Bento\Tests\Unit\Strategy;

use Carbon\Carbon;
use Exolnet\Bento\Strategy\Date;
use Exolnet\Bento\Tests\UnitTest;
use InvalidArgumentException;

class DateTest extends UnitTest
{
    /**
     * @return void
     * @test
     */
    public function testLaunchDateIsToday(): void
    {
        Carbon::setTestNow($date = Carbon::now());
        $strategy = new Date($date, '=');
        $this->assertTrue($strategy->launch());
    }

    /**
     * @return void
     * @test
     */
    public function testLaunchDateWasYesterday(): void
    {
        //Launch is true since yesterday
        $date = Carbon::now()->subDay();
        $strategy = new Date($date, '<');
        $this->assertTrue($strategy->launch());

        //launch is tru since the day before yesterday at 23:59:59.999999
        $date = Carbon::now()->endOfDay()->subDays(2);
        $strategy = new Date($date, '<=');
        $this->assertTrue($strategy->launch());
    }

    /**
     * @return void
     * @test
     */
    public function testLaunchDateIsTomorrow(): void
    {
        //Launch is true from tomorrow
        $date = Carbon::now()->addDay();
        $strategy = new Date($date, '>');
        $this->assertTrue($strategy->launch());

        //Launch is true from today at 23:59:59.999999
        $date = Carbon::now()->endOfDay();
        $strategy = new Date($date, '>=');
        $this->assertTrue($strategy->launch());
    }

    /**
     * @return void
     * @test
     */
    public function testNoLaunchIfOperatorInvalid(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $date = Carbon::now()->addDay();
        $strategy = new Date($date, ']');
        $strategy->launch();
    }
}
