<?php namespace Exolnet\Bento\Tests\Integration;

use Exolnet\Bento\Bento;
use PHPUnit_Framework_TestCase;

class StrategiesTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \Exolnet\Bento\Bento
     */
    protected $bento;

    public function setUp()
    {
        $this->bento = new Bento();
    }

    public function testEveryoneStrategy()
    {
        $isLaunched = $this->bento->aim('name', 'everyone')->isLaunched();

        $this->assertTrue($isLaunched);
    }

    public function testNobodyStrategy()
    {
        $isLaunched = $this->bento->aim('name', 'nobody')->isLaunched();

        $this->assertFalse($isLaunched);
    }
}
