<?php

namespace OpenSky\Bundle\GigyaBundle\Tests;

use OpenSky\Bundle\GigyaBundle\Socializer;
use OpenSky\Bundle\GigyaBundle\Socializer\UserAction;

class SocializerTest extends \PHPUnit_Framework_TestCase
{
    private $socializer;

    public function setUp()
    {
        parent::setup();
        $this->apiKey = 'xxxx';
        $this->namespace = 'AntiMattr';
        $this->socializer = new Socializer($this->apiKey, $this->namespace);
    }

    public function tearDown()
    {
        $this->socializer = null;
        $this->namespace = null;
        $this->apiKey = null;
        parent::tearDown();
    }

    public function testConstructor()
    {
        $this->assertEquals($this->apiKey, $this->socializer->getApiKey());
        $this->assertEquals($this->namespace, $this->socializer->getNamespace());
    }

    public function testHasSetGetUserActionByKey()
    {
        $key = 'foo';
        $this->assertFalse($this->socializer->hasUserActionByKey($key));

        $userAction = new UserAction();
        $this->socializer->addUserActionByKey($userAction, $key);

        $this->assertTrue($this->socializer->hasUserActionByKey($key));
        $this->assertEquals($userAction, $this->socializer->getUserActionByKey($key));
    }
}
