<?php

namespace OpenSky\Bundle\GigyaBundle\Tests\Socializer;

use Buzz\Message\Request;
use Buzz\Message\Response;
use OpenSky\Bundle\GigyaBundle\Socializer\Socializer;
use OpenSky\Bundle\GigyaBundle\Socializer\UserAction;
use OpenSky\Bundle\GigyaBundle\Tests\GigyaTestCase;

class SocializerTest extends GigyaTestCase
{
    private $socializer;
    private $client;
    private $factory;

    public function setUp()
    {
        parent::setUp();
        $this->apiKey     = 'xxxx';
        $this->providers  = array(1, 2, 3);
        $this->client     = $this->getMockClient();
        $this->factory    = $this->getMockMessageFactory();
        $this->socializer = $this->getSocializer($this->client, $this->factory);
    }

    public function testConstructor()
    {
        $this->assertEquals($this->apiKey, $this->socializer->getApiKey());
        $this->assertEquals($this->providers, $this->socializer->getProviders());
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
        $request  = new Request();
        $response = new Response();

        $this->factory->expects($this->once())
            ->method('getLoginRequest')
            ->with($provider)
            ->will($this->returnValue($request));

        $this->factory->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue($response));

        $this->client->expects($this->once())
            ->method('send')
            ->with($request, $response);

        $this->assertSame($response, $this->socializer->login($provider));
    }

    public function testGetAccessToken()
    {
        $request  = new Request();
        $response = new Response();

        $response->addHeaders(array(
            'Content-Type' => 'application/json'
        ));

        $response->setContent(
'{
    "access_token":"SlAV32hkKG",
    "expires_in":3600
}'
        );

        $this->factory->expects($this->once())
            ->method('getAccessTokenRequest')
            ->will($this->returnValue($request));

        $this->factory->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue($response));

        $this->client->expects($this->once())
            ->method('send')
            ->with($request, $response);

        $this->assertEquals(array(
            'access_token' => 'SlAV32hkKG',
            'expires_in'   => 3600
        ), $this->socializer->getAccessToken());
    }

    /**
     * @expectedException Symfony\Component\Security\Core\Exception\AuthenticationException
     */
    public function testShouldNotAuthorize()
    {
        $request  = new Request();
        $response = new Response();

        $response->addHeaders(array(
            'Content-Type' => 'application/json'
        ));

        $response->setContent(
'{
    "error":500001,
    "error_description":"500001 - Server error"
}'
        );

        $this->factory->expects($this->once())
            ->method('getAccessTokenRequest')
            ->will($this->returnValue($request));

        $this->factory->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue($response));

        $this->client->expects($this->once())
            ->method('send')
            ->with($request, $response);

        $this->socializer->getAccessToken();
    }
}
