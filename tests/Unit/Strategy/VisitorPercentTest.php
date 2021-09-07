<?php

namespace Exolnet\Bento\Tests\Unit\Strategy;

use Exolnet\Bento\Bento;
use Exolnet\Bento\Feature;
use Exolnet\Bento\Strategy\VisitorPercent;
use Exolnet\Bento\Tests\UnitTest;
use Mockery;

class VisitorPercentTest extends UnitTest
{
    /**
     * @var \Exolnet\Bento\Bento
     */
    protected $bento;

    /**
     * @var \Exolnet\Bento\Feature
     */
    protected $feature;

    /**
     * @var \Exolnet\Bento\Strategy\VisitorPercent
     */
    protected $visitorPercent;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->bento = Mockery::mock(Bento::class);
        $this->feature = Mockery::mock(Feature::class);
        $this->visitorPercent = new VisitorPercent($this->bento, 50);

        $this->visitorPercent->setFeature($this->feature);
    }

    /**
     * @return void
     * @test
     */
    public function testGetFeature(): void
    {
        $this->bento->shouldReceive('getVisitorId')->once()->andReturn(1234);

        $this->assertEquals(1234, $this->visitorPercent->getUniqueId());
    }

    /**
     * @return void
     * @test
     */
    public function testGetPercent(): void
    {
        $this->assertEquals(50, $this->visitorPercent->getPercent());
    }
}
