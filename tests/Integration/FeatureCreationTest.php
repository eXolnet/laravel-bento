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

    public function setUp()
    {
        parent::setUp();

        $this->bento = BentoFacade::getFacadeRoot();
    }

    public function testCreateNewFeature()
    {
        $feature = $this->bento->feature('name');

        $this->assertInstanceOf(Feature::class, $feature);
    }

    public function testFeatureAimFluent()
    {
        $feature = $this->bento->feature('name')->aim('visitor-percent', 10);

        $this->assertInstanceOf(Feature::class, $feature);
        $this->assertCount(1, $feature->getStrategies());
    }

    public function testFeatureAim()
    {
        $feature = $this->bento->aim('name', 'visitor-percent', 10);

        $this->assertInstanceOf(Feature::class, $feature);
        $this->assertCount(1, $feature->getStrategies());
    }

    public function testLaunchFeatureDefault()
    {
        $launch = $this->bento->launch('name');

        $this->assertFalse($launch);
    }
}
