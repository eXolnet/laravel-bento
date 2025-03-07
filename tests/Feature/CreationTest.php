<?php

namespace Exolnet\Bento\Tests\Feature;

use BadMethodCallException;
use Carbon\Carbon;
use Exolnet\Bento\Facades\Bento;
use Exolnet\Bento\Feature;
use Exolnet\Bento\Tests\Fixtures\CustomStrategy;
use Exolnet\Bento\Tests\TestCase;

class CreationTest extends TestCase
{
    /**
     * @var \Exolnet\Bento\Bento
     */
    protected $bento;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->bento = Bento::getFacadeRoot();
    }

    /**
     * @return void
     */
    public function testCreateNewFeature(): void
    {
        $feature = $this->bento->feature('name');

        $this->assertInstanceOf(Feature::class, $feature);
    }

    /**
     * @return void
     */
    public function testFeatureAimFluent(): void
    {
        $feature = $this->bento->feature('name')->aim('visitor-percent', 10);

        $this->assertInstanceOf(Feature::class, $feature);
        $this->assertCount(1, $feature->getStrategies());
    }

    /**
     * @return void
     */
    public function testFeatureAimFluentProxy(): void
    {
        $feature = $this->bento->feature('name')->visitorPercent(10);

        $this->assertInstanceOf(Feature::class, $feature);
        $this->assertCount(1, $feature->getStrategies());
    }

    /**
     * @return void
     */
    public function testFeatureAim(): void
    {
        $feature = $this->bento->feature('name')->aim('visitor-percent', 10);

        $this->assertInstanceOf(Feature::class, $feature);
        $this->assertCount(1, $feature->getStrategies());
    }

    /**
     * @return void
     */
    public function testInvalidAim(): void
    {
        $this->expectException(BadMethodCallException::class);

        $this->bento->feature('name')->invalid();
    }

    /**
     * @return void
     */
    public function testLaunchFeatureDefault(): void
    {
        $launch = $this->bento->launch('name');

        $this->assertFalse($launch);
    }

    /**
     * @return void
     */
    public function testCreateNewFeatureWithDefaultParam(): void
    {
        // Default operator is >=
        $date = Carbon::yesterday();
        $this->assertFalse($this->bento->feature('name2')->aim('date', $date)->launch());
        $date = Carbon::tomorrow();
        $this->assertTrue($this->bento->feature('name3')->aim('date', $date)->launch());
    }

    /**
     * @return void
     */
    public function testCreateNewFeatureWithInjection(): void
    {
        Carbon::setTestNow($date = Carbon::now());

        $this->assertTrue($this->bento->feature('name4')->aim('date', $date, '=')->launch());
    }

    /**
     * @return void
     */
    public function testCreateNewFeatureWithParameterAlreadyInParameters(): void
    {
        $this->assertTrue($this->bento->feature('name3')->aim('visitor-percent', $this->bento, 100)->launch());

        $this->assertTrue($this->bento->feature('name4')->aim('visitor-percent', 100)->launch());
    }

    /**
     * @return void
     */
    public function testNotHigherOrderProxy(): void
    {
        $this->assertFalse($this->bento->feature('name1')->not->everyone()->launch());

        $this->assertTrue($this->bento->feature('name2')->not->nobody()->launch());
    }

    /**
     * @return void
     */
    public function testCustomStrategyClass(): void
    {
        $this->assertTrue($this->bento->feature('name1')->aim(CustomStrategy::class, true)->launch());
        $this->assertFalse($this->bento->feature('name2')->aim(CustomStrategy::class, false)->launch());
    }
}
