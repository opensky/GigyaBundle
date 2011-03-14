<?php

namespace OpenSky\Bundle\GigyaBundle\Tests\Socializer\Buzz;

use Buzz\Message\Request;
use OpenSky\Bundle\GigyaBundle\Socializer\Buzz\MessageFactory;
use OpenSky\Bundle\GigyaBundle\Tests\GigyaTestCase;

class MessageFactoryTest extends GigyaTestCase
{
    private $factory;
    private $router;
    private $apiHost = 'https://socialize.gigya.com';
    private $secret  = 'secret';
    private $route   = 'gigya.api.login.redirect';

    protected function setUp()
    {
        $this->router  = $this->getMockRouter();
        $this->factory = new MessageFactory($this->router, $this->apiKey, $this->secret, $this->apiHost, $this->route);
    }

    public function testSouldGenerateCorrectLoginRequest()
    {
        $provider = 'twitter';
        $redirect = 'http://shopopensky.gigya/gigya';
        $request  = new Request(Request::METHOD_POST, '/socialize.login', $this->apiHost);

        $request->setHeaders(array(
            'Content-Type'  => 'application/x-www-form-urlencoded'
        ));

        $request->setContent(http_build_query(array(
            'x_provider'    => $provider,
            'client_id'     => $this->apiKey,
            'redirect_uri'  => $redirect,
            'response_type' => 'token'
        )));

        $this->router->expects($this->once())
            ->method('generate')
            ->with($this->route, array())
            ->will($this->returnValue($redirect));

        $this->assertEquals($request, $this->factory->getLoginRequest($provider));
    }

    public function testGetAccessTokenRequest()
    {
        $request  = new Request(Request::METHOD_POST, '/socialize.getToken', $this->apiHost);

        $request->setHeaders(array(
            'Content-Type'  => 'application/x-www-form-urlencoded',
            'Authorization' => 'Basic '.base64_encode($this->apiKey.':'.$this->secret),
        ));

        $request->setContent(http_build_query(array(
            'grant_type'    => 'none',
        )));

        $this->assertEquals($request, $this->factory->getAccessTokenRequest());
    }

    public function testGetUserInfoRequest()
    {
        $token   = 'access-token';
        $request = new Request(Request::METHOD_POST, '/socialize.getUserInfo', $this->apiHost);

        $request->setHeaders(array(
            'Content-Type'  => 'application/x-www-form-urlencoded',
            'Authorization' => 'OAuth '.$token,
        ));

        $request->setContent(http_build_query(array(
            'format' => 'xml',
        )));

        $this->assertEquals($request, $this->factory->getUserInfoRequest($token));
    }

    private function getMockRouter()
    {
        return $this->getMock('Symfony\Component\Routing\RouterInterface');
    }
}
