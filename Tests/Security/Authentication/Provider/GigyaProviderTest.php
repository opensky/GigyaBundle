<?php

namespace OpenSky\Bundle\GigyaBundle\Tests\Security\Authentication\Provider;

use OpenSky\Bundle\GigyaBundle\Security\Authentication\Token\GigyaToken;

use OpenSky\Bundle\GigyaBundle\Security\Authentication\Provider\GigyaProvider;
use OpenSky\Bundle\GigyaBundle\Socializer\Socializer;
use OpenSky\Bundle\GigyaBundle\Tests\GigyaTestCase;

class GigyaProviderTest extends GigyaTestCase
{
    private $socializer;
    private $provider;

    public function setUp()
    {
        $this->socializer = $this->getSocializer($this->getMockClient(), $this->getMockMessageFactory());
        $this->provider = new GigyaProvider($this->socializer);
    }

    public function testShouldSupportGigyaTokenOnly()
    {
        $this->assertTrue($this->provider->supports(new GigyaToken('aabsd')));
        $this->assertFalse($this->provider->supports($this->getMockToken()));
    }

    /**
     * @expectedException Symfony\Component\Security\Core\Exception\UnsupportedAccountException
     */
    public function testShouldNotLoadUserByAccount()
    {
        $this->provider->loadUserByAccount($this->getMockAccount());
    }

    public function testShouldNotAuthenticateIfUnsuportedToken()
    {
        $this->assertNull($this->provider->authenticate($this->getMockToken()));
    }

    public function testShouldAuthenticateWithAccessToken()
    {
        $this->markTestSkipped();
        $gigyaToken = $this->provider->authenticate($this->getMockToken());

        $this->assertInstanceOf('OpenSky\Bundle\GigyaBundle\Security\Authentication\Token\GigyaToken', $gigyaToken);
    }

    private function getMockToken()
    {
        return $this->getMock('Symfony\Component\Security\Core\Authentication\Token\TokenInterface');
    }

    private function getMockAccount()
    {
        return $this->getMock('Symfony\Component\Security\Core\User\AccountInterface');
    }
}
