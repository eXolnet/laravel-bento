<?php namespace Exolnet\Segment\Tests\Integration;

use Exolnet\Segment\Feature;
use Exolnet\Segment\Segment;
use PHPUnit_Framework_TestCase;

class FeatureCreationTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \Exolnet\Segment\Segment::__construct
     */
    protected $segment;

    public function setUp()
    {
        $this->segment = new Segment();
    }

    public function testCreateNewFeature()
    {
        $feature = $this->segment->feature('name');

        $this->assertInstanceOf(Feature::class, $feature);
    }

    public function testFeatureAimFluent()
    {
        $feature = $this->segment->feature('name')->aim('percent', 10);

        $this->assertInstanceOf(Feature::class, $feature);
        $this->assertCount(1, $feature->getStrategies());
    }

    public function testFeatureAim()
    {
        $feature = $this->segment->aim('name', 'percent', 10);

        $this->assertInstanceOf(Feature::class, $feature);
        $this->assertCount(1, $feature->getStrategies());
    }

    public function testLaunchFeatureDefault()
    {
        $isLaunched = $this->segment->isLaunched('name');

        $this->assertTrue($isLaunched);
    }
}
