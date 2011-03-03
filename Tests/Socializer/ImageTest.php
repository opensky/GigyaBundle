<?php

namespace AntiMattr\GigyaBundle\Tests\Socializer;

use AntiMattr\GigyaBundle\Socializer\MediaItemInterface;
use AntiMattr\GigyaBundle\Socializer\Image;

class ImageTest extends \PHPUnit_Framework_TestCase
{
    private $src;
    private $type;
    private $image;

    public function setUp()
    {
        parent::setup();
        $this->src = 'foo';
        $this->href = 'value';
        $this->image = new StubImage($this->src, $this->href);
    }

    public function tearDown()
    {
        $this->image = null;
        $this->href = null;
        $this->src = null;
        parent::tearDown();
    }

    public function testConstructor()
    {
        $this->assertEquals($this->src, $this->image->getSrc());
        $this->assertEquals($this->href, $this->image->getHref());
    }

    public function testGetType()
    {
        $this->assertEquals(MediaItemInterface::IMAGE, $this->image->getType());
    }

    public function testToArray()
    {
        $expectedArray = array(
            'href' => $this->href,
            'src' => $this->src,
            'type' => MediaItemInterface::IMAGE
        );

        $this->assertEquals($expectedArray, $this->image->internalToArray());
    }
}

class StubImage extends Image
{
    public function internalToArray()
    {
        return $this->toArray();
    }
}
