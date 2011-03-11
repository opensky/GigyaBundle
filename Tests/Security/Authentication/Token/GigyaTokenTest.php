<?php

namespace OpenSky\Bundle\GigyaBundle\Tests\Security\Authentication\Token;

use OpenSky\Bundle\GigyaBundle\Security\Authentication\Token\GigyaToken;

class GigyaTokenTest extends \PHPUnit_Framework_TestCase
{
    private $accessToken = 'xxxxxx';

    /**
     * @dataProvider getTokens
     *
     * @param OpenSky\Bundle\GigyaBundle\Security\Authentication\Token\GigyaToken $token
     */
    public function testShouldSerializeAndUnserialize(GigyaToken $token)
    {
        $serializedToken = serialize($token);

        $this->assertContains($this->accessToken, $serializedToken);

        $this->assertEquals($token, unserialize($serializedToken));
    }

    public function getTokens()
    {
        return array(
            array(new GigyaToken($this->accessToken)),
            array(new GigyaToken($this->accessToken, new \DateTime())),
        );
    }
}
