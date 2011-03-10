<?php

namespace OpenSky\Bundle\GigyaBundle\Tests\Socializer\Buzz;

use Buzz\Message\Request;
use OpenSky\Bundle\GigyaBundle\Socializer\Buzz\MessageFactory;

class MessageFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testSouldGenerateCorrectLoginRequest()
    {
        $apiKey   = 'xxxxxx';
        $apiHost  = 'https://socialize.gigya.com';
        $provider = 'twitter';
        $redirect = 'http://shopopensky.gigya/gigya';
        $factory  = new MessageFactory($apiKey, $apiHost, $redirect);
        $request  = new Request(Request::METHOD_POST, $resource = '/socialize.login', $apiHost);

        $request->setContent(http_build_query(array(
            'x_provider'    => $provider,
            'client_id'     => $apiKey,
            'redirect_uri'  => $redirect,
            'response_type' => 'token'
        )));

        $this->assertEquals($request, $factory->getLoginMessage($provider));
    }
}
