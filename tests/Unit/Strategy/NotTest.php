<?php

namespace Exolnet\Bento\Tests\Unit\Strategy;

use Exolnet\Bento\Bento;
use Exolnet\Bento\Feature;
use Exolnet\Bento\Strategy\Everyone;
use Exolnet\Bento\Strategy\Not;
use Exolnet\Bento\Tests\UnitTest;
use Mockery;

class NotTest extends UnitTest
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
     * @var \Exolnet\Bento\Strategy\Not
     */
    protected $not;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->bento = Mockery::mock(Bento::class);
        $this->feature = Mockery::mock(Feature::class);
    }

    /**
     * @return void
     * @test
     */
    public function testGetFeature(): void
    {
        $this->not = new Not(function () {});
        $this->assertNull($this->not->getFeature());

        $this->not->setFeature($this->feature);
        $this->assertEquals($this->feature, $this->not->getFeature());
    }
}
