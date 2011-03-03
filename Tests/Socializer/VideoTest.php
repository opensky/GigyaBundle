<?php

namespace AntiMattr\GigyaBundle\Tests\Socializer;

use AntiMattr\GigyaBundle\Socializer\MediaItemInterface;
use AntiMattr\GigyaBundle\Socializer\Video;

class VideoTest extends \PHPUnit_Framework_TestCase
{
    private $previewImageUrl;
    private $src;
    private $type;
    private $video;

    public function setUp()
    {
        parent::setup();
        $this->src = 'foo';
        $this->previewImageUrl = 'bar';
        $this->type = 'flash';
        $this->video = new Video($this->src, $this->previewImageUrl, $this->type);
    }

    public function tearDown()
    {
        $this->video = null;
        $this->type = 'flash';
        $this->previewImageUrl = null;
        $this->src = null;
        parent::tearDown();
    }

    public function testConstructor()
    {
        $this->assertEquals($this->src, $this->video->getSrc());
        $this->assertEquals($this->previewImageUrl, $this->video->getPreviewImageUrl());
        $this->assertEquals($this->type, $this->video->getType());
    }

    public function testGetType()
    {
        $this->assertEquals(MediaItemInterface::FLASH, $this->video->getType());
    }

    public function testToArray()
    {
        $expectedArray = array(
            'previewImageUrl' => $this->previewImageUrl,
            'src' => $this->src,
            'type' => MediaItemInterface::FLASH
        );

        $this->assertEquals($expectedArray, $this->video->toArray());
    }
}
