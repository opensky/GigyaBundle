<?php

namespace OpenSky\Bundle\GigyaBundle\Tests\Socializer\Buzz;

use Buzz\Message\Request;
use OpenSky\Bundle\GigyaBundle\Socializer\Buzz\MessageFactory;
use OpenSky\Bundle\GigyaBundle\Tests\GigyaTestCase;

class MessageFactoryTest extends GigyaTestCase
{
    private $factory;
    private $apiHost  = 'https://socialize.gigya.com';
    private $secret   = 'secret';

    protected function setUp()
    {
        $this->router  = $this->getMockRouter();
        $this->factory = new MessageFactory($this->apiKey, $this->secret, $this->apiHost);
    }

    public function testSouldGenerateCorrectLoginRequest()
    {
        $provider = 'twitter';
        $redirect = 'http://shopopensky.gigya/gigya';
        $request  = new Request(Request::METHOD_POST, '/socialize.login', $this->apiHost);

        $this->factory->setRedirectUri($redirect);

        $request->setContent(http_build_query(array(
            'x_provider'    => $provider,
            'client_id'     => $this->apiKey,
            'redirect_uri'  => $redirect,
            'response_type' => 'code'
        )));

        $this->assertEquals($request, $this->factory->getLoginRequest($provider, $redirect));
    }

    public function testGetAccessTokenRequest()
    {
        $request  = new Request(Request::METHOD_POST, '/socialize.getToken?client_id='.$this->apiKey.'&client_secret='.$this->secret, $this->apiHost);
        $code     = 'asd';

        $request->setContent(http_build_query(array(
            'grant_type'    => 'authorization_code',
            'code'          => $code,
        )));

        $this->assertEquals($request, $this->factory->getAccessTokenRequest($code));
    }

    public function testGetUserInfoRequest()
    {
        $token   = 'access-token';
        $request = new Request(Request::METHOD_POST, '/socialize.getUserInfo?'.http_build_query(array(
            'apiKey'      => $this->apiKey,
            'secret'      => $this->secret,
            'oauth_token' => $token,
            'nonce'       => $token,
            'timestamp'   => time(),
        )), $this->apiHost);

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
