<?php

namespace OpenSky\Bundle\GigyaBundle\Tests\Socializer;

use OpenSky\Bundle\GigyaBundle\Socializer\MediaItemInterface;
use OpenSky\Bundle\GigyaBundle\Socializer\Audio;

class AudioTest extends \PHPUnit_Framework_TestCase
{
    private $src;
    private $type;
    private $audio;

    public function setUp()
    {
        parent::setup();
        $this->src = 'foo';
        $this->href = 'value';
        $this->audio = new StubAudio($this->src, $this->href);
    }

    public function tearDown()
    {
        $this->audio = null;
        $this->href = null;
        $this->src = null;
        parent::tearDown();
    }

    public function testConstructor()
    {
        $this->assertEquals($this->src, $this->audio->getSrc());
        $this->assertEquals($this->href, $this->audio->getHref());
    }

    public function testGetType()
    {
        $this->assertEquals(MediaItemInterface::AUDIO, $this->audio->getType());
    }

    public function testToArray()
    {
        $expectedArray = array(
            'href' => $this->href,
            'src' => $this->src,
            'type' => MediaItemInterface::AUDIO
        );

        $this->assertEquals($expectedArray, $this->audio->internalToArray());
    }
}

class StubAudio extends Audio
{
    public function internalToArray()
    {
        return $this->toArray();
    }
}
