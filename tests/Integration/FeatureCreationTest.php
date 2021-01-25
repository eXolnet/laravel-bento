<?php

namespace Exolnet\Bento\Tests\Integration;

use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;
use Exolnet\Bento\Facades\Bento;
use Exolnet\Bento\Feature;
use Exolnet\Bento\Tests\IntegrationTest;

class FeatureCreationTest extends IntegrationTest
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
    public function testFeatureAim(): void
    {
        $feature = $this->bento->aim('name', 'visitor-percent', 10);

        $this->assertInstanceOf(Feature::class, $feature);
        $this->assertCount(1, $feature->getStrategies());
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
    public function testCreateNewFeatureWithDefaultParam():void
    {
        //Default operator is >=
        $date = Carbon::now();
        self::assertFalse($this->bento->aim('name2', 'date', $date)->launch());
        $date = Carbon::tomorrow();
        self::assertTrue($this->bento->aim('name3', 'date', $date)->launch());
    }

    /**
     * @return void
     */
    public function testCreateNewFeatureWithInjection():void
    {
        $date = Carbon::now();
        self::assertTrue($this->bento->aim('name4', 'date', $date, '=')->launch());
    }

    /**
     * @return void
     */
    public function testCreateNewFeatureWithParameterAlreadyInParamters():void
    {
        self::assertTrue($this->bento
            ->aim('name3', 'visitorpercent', $this->bento, 100)
            ->launch());

        self::assertTrue($this->bento
            ->aim('name4', 'visitorpercent', 100)
            ->launch());
    }
}
