<?php
use Polygon\Polygon;

class PolygonTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Polygon
     */
    private $polygon;

    public function setUp()
    {
        $this->polygon = new Polygon([
            [0, 0],
            [0, 1],
            [1, 1],
            [1, 0],
        ]);
    }

    public function testPointInPolygon()
    {
        $this->assertTrue($this->polygon->contain(0.5, 0.5));
    }

    public function testIsValid()
    {
        $this->assertTrue($this->polygon->isValid());
    }

    public function testIsInvalid()
    {
        $this->polygon->setPoints([
            [0, 0],
            [0, 1],
        ]);
        $this->assertFalse($this->polygon->isValid());
    }
}
