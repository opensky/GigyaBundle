<?php

namespace OpenSky\Bundle\GigyaBundle\Tests\Socializer;

use OpenSky\Bundle\GigyaBundle\Socializer\MediaItemInterface;
use OpenSky\Bundle\GigyaBundle\Socializer\Video;

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
        $this->href = 'value';
        $this->video = new StubVideo($this->src, $this->previewImageUrl, $this->href);
    }

    public function tearDown()
    {
        $this->video = null;
        $this->href = null;
        $this->previewImageUrl = null;
        $this->src = null;
        parent::tearDown();
    }

    public function testConstructor()
    {
        $this->assertEquals($this->src, $this->video->getSrc());
        $this->assertEquals($this->previewImageUrl, $this->video->getPreviewImageUrl());
        $this->assertEquals($this->href, $this->video->getHref());
    }

    public function testGetType()
    {
        $this->assertEquals(MediaItemInterface::VIDEO, $this->video->getType());
    }

    public function testToArray()
    {
        $expectedArray = array(
            'href' => $this->href,
            'previewImageUrl' => $this->previewImageUrl,
            'src' => $this->src,
            'type' => MediaItemInterface::VIDEO
        );

        $this->assertEquals($expectedArray, $this->video->internalToArray());
    }
}

class StubVideo extends Video
{
    public function internalToArray()
    {
        return $this->toArray();
    }
}
