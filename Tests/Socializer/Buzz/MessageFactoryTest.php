<?php

namespace OpenSky\Bundle\GigyaBundle\Tests\Socializer\Buzz;

use Buzz\Message\Request;
use OpenSky\Bundle\GigyaBundle\Socializer\Buzz\MessageFactory;

class MessageFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testSouldGenerateCorrectLoginRequest()
    {
        $apiKey   = 'xxxxxx';
        $secret   = 'zzzzzz';
        $apiHost  = 'https://socialize.gigya.com';
        $provider = 'twitter';
        $route    = 'gigya.api.login.redirect';
        $redirect = 'http://shopopensky.gigya/gigya';
        $router   = $this->getMock('Symfony\Component\Routing\RouterInterface');
        $factory  = new MessageFactory($router, $apiKey, $secret, $apiHost, $route);
        $request  = new Request(Request::METHOD_POST, '/socialize.login', $apiHost);

        $request->setContent(http_build_query(array(
            'x_provider'    => $provider,
            'client_id'     => $apiKey,
            'redirect_uri'  => $redirect,
            'response_type' => 'token'
        )));

        $router->expects($this->once())
            ->method('generate')
            ->with($route, array())
            ->will($this->returnValue($redirect));

        $this->assertEquals($request, $factory->getLoginRequest($provider));
    }
}
