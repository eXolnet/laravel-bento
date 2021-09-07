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
        $strategy = Mockery::mock(Everyone::class);

        $this->bento->shouldReceive('makeStrategy')->once()->andReturn($strategy);
        $this->not = new Not($this->bento, $this->feature, 'everyone');

        self::assertEquals($this->feature, $this->not->getFeature());
    }
}
