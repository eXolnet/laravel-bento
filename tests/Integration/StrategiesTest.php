<?php namespace Exolnet\Segment\Tests\Integration;

use Exolnet\Segment\Segment;
use PHPUnit_Framework_TestCase;

class StrategiesTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \Exolnet\Segment\Segment::__construct
     */
    protected $segment;

    public function setUp()
    {
        $this->segment = new Segment();
    }

    public function testEveryoneStrategy()
    {
        $isLaunched = $this->segment->aim('name', 'everyone')->isLaunched();

        $this->assertTrue($isLaunched);
    }

    public function testNobodyStrategy()
    {
        $isLaunched = $this->segment->aim('name', 'nobody')->isLaunched();

        $this->assertFalse($isLaunched);
    }
}
