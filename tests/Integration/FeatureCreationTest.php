<?php namespace Exolnet\Bento\Tests\Integration;

use Exolnet\Bento\Feature;
use Exolnet\Bento\Bento;
use PHPUnit_Framework_TestCase;

class FeatureCreationTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \Exolnet\Bento\Bento
     */
    protected $bento;

    public function setUp()
    {
        $this->bento = new Bento();
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
        $isLaunched = $this->bento->isLaunched('name');

        $this->assertFalse($isLaunched);
    }
}
