<?php

namespace OpenSky\Bundle\GigyaBundle\Tests\Socializer;

use OpenSky\Bundle\GigyaBundle\Socializer\ActionLink;
use OpenSky\Bundle\GigyaBundle\Socializer\UserAction;
use OpenSky\Bundle\GigyaBundle\Socializer\Video;

class UserActionTest extends \PHPUnit_Framework_TestCase
{
    private $userAction;

    public function setUp()
    {
        parent::setup();
        $this->userAction = new UserAction();
    }

    public function tearDown()
    {
        $this->userAction = null;
        parent::tearDown();
    }

    public function testConstructor()
    {
        $this->assertEquals(0, count($this->userAction->getActionLinks()));
        $this->assertNull($this->userAction->getDescription());
        $this->assertNull($this->userAction->getLinkBack());
        $this->assertEquals(0, count($this->userAction->getMediaItems()));
        $this->assertNull($this->userAction->getTitle());
        $this->assertNull($this->userAction->getUserMessage());
    }

    public function testAddHasGetActionLink()
    {
        $title = 'foo';
        $destination = 'bar';
        $actionLink = new ActionLink($title, $destination);
        $this->assertFalse($this->userAction->hasActionLink($actionLink));

        $this->userAction->addActionLink($actionLink);
        $this->assertTrue($this->userAction->hasActionLink($actionLink));

        $this->assertEquals(1, count($this->userAction->getActionLinks()));
    }

    public function testSetGetDescription()
    {
        $val = "desc";
        $this->userAction->setDescription($val);
        $this->assertEquals($val, $this->userAction->getDescription());
    }

    public function testSetGetLinkBack()
    {
        $val = "link";
        $this->userAction->setLinkBack($val);
        $this->assertEquals($val, $this->userAction->getLinkBack());
    }

    public function testAddHasGetMediaItem()
    {
        $src = 'foo';
        $previewImageUrl = 'bar';
        $type = 'flash';
        $video = new Video($src, $previewImageUrl, $type);
        $this->assertFalse($this->userAction->hasMediaItem($video));

        $this->userAction->addMediaItem($video);
        $this->assertTrue($this->userAction->hasMediaItem($video));

        $this->assertEquals(1, count($this->userAction->getMediaItems()));
    }

    public function testSetGetTitle()
    {
        $val = "title";
        $this->userAction->setTitle($val);
        $this->assertEquals($val, $this->userAction->getTitle());
    }

    public function testSetGetUserMessage()
    {
        $val = "user message";
        $this->userAction->setUserMessage($val);
        $this->assertEquals($val, $this->userAction->getUserMessage());
    }
}
