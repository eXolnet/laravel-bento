<?php

namespace Exolnet\Bento\Tests\Integration;

use Exolnet\Bento\BentoFacade;
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

        $this->bento = BentoFacade::getFacadeRoot();
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
}
