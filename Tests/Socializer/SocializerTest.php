<?php

namespace OpenSky\Bundle\GigyaBundle\Tests\Socializer;

use Buzz\Message\Request;

use OpenSky\Bundle\GigyaBundle\Socializer\Socializer;
use OpenSky\Bundle\GigyaBundle\Socializer\UserAction;

class SocializerTest extends \PHPUnit_Framework_TestCase
{
    private $socializer;
    private $apiKey;
    private $client;
    private $factory;

    public function setUp()
    {
        parent::setup();
        $this->apiKey     = 'xxxx';
        $this->client     = $this->getMockClient();
        $this->factory    = $this->getMockMessageFactory();
        $this->socializer = new Socializer($this->apiKey, $this->client, $this->factory);
    }

    public function testConstructor()
    {
        $this->assertEquals($this->apiKey, $this->socializer->getApiKey());
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

    public function testLogin()
    {
        $provider = 'twitter';
        $message  = new Request();

        $this->factory->expects($this->once())
            ->method('getLoginMessage')
            ->with($provider)
            ->will($this->returnValue($message));

        $this->client->expects($this->once())
            ->method('send')
            ->with($message);

        $this->socializer->login($provider);
    }

    private function getMockMessageFactory()
    {
        return $this->getMockBuilder('OpenSky\Bundle\GigyaBundle\Socializer\Buzz\MessageFactory')
            ->disableOriginalConstructor()
            ->getMock();
    }

    private function getMockClient()
    {
        return $this->getMock('Buzz\Client\ClientInterface');
    }
}
