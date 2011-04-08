<?php

namespace OpenSky\Bundle\GigyaBundle\Tests\Security\Authentication\Provider;

use OpenSky\Bundle\GigyaBundle\Security\Authentication\Token\GigyaToken;
use OpenSky\Bundle\GigyaBundle\Security\Authentication\Provider\GigyaProvider;
use OpenSky\Bundle\GigyaBundle\Security\User\User;
use OpenSky\Bundle\GigyaBundle\Socializer\Socializer;
use OpenSky\Bundle\GigyaBundle\Tests\GigyaTestCase;

class GigyaProviderTest extends GigyaTestCase
{
    private $socializer;
    private $provider;
    private $providerKey = 'secret';

    public function setUp()
    {
        $this->socializer = $this->getSocializerMock();
        $this->provider = new GigyaProvider($this->socializer, $this->providerKey);
    }

    public function testShouldSupportGigyaTokenOnly()
    {
        $this->assertTrue($this->provider->supports(new GigyaToken('', '', $this->providerKey)));
        $this->assertFalse($this->provider->supports($this->getMockToken()));
    }

    public function testShouldNotAuthenticateIfUnsuportedToken()
    {
        $this->assertNull($this->provider->authenticate($this->getMockToken()));
    }

    public function testShouldAuthenticateWithAccessTokenAndNoUserProvider()
    {
        $userId      = '123';
        $user        = new User($userId, 'social');
        $code        = 'secret';
        $token       = 'test';
        $accessToken = array('access_token' => $token);

        $this->socializer->expects($this->once())
            ->method('getAccessToken')
            ->with($code)
            ->will($this->returnValue($accessToken));

        $this->socializer->expects($this->once())
            ->method('getUser')
            ->with($token)
            ->will($this->returnValue($user));

        $gigya = $this->provider->authenticate(new GigyaToken('', $code, $this->providerKey));

        $this->assertInstanceOf('OpenSky\Bundle\GigyaBundle\Security\Authentication\Token\GigyaToken', $gigya);
        $this->assertSame($user, $gigya->getUser());
    }

    public function testShouldAuthenticateWithAccessTokenAndUserProvider()
    {
        $userId      = '123';
        $provider    = 'social';
        $code        = 'secret';
        $user        = new User($userId, $provider);
        $token       = 'test';
        $accessToken = array('access_token' => $token);
        $account     = $this->getMockAccount();

        $account->expects($this->once())
            ->method('getRoles')
            ->will($this->returnValue(array()));

        $provider = $this->getMockUserProvider();
        $checker  = $this->getMockAccountChecker();

        $gigyaProvider = new GigyaProvider($this->socializer, $this->providerKey, $provider, $checker);

        $this->socializer->expects($this->once())
            ->method('getAccessToken')
            ->with($code)
            ->will($this->returnValue($accessToken));

        $this->socializer->expects($this->once())
            ->method('getUser')
            ->with($token)
            ->will($this->returnValue($user));

        $provider->expects($this->once())
            ->method('loadUserByUsername')
            ->with($userId)
            ->will($this->returnValue($account));

        $checker->expects($this->once())
            ->method('checkPreAuth')
            ->with($account);

        $checker->expects($this->once())
            ->method('checkPostAuth')
            ->with($account);

        $gigya = $gigyaProvider->authenticate(new GigyaToken('', $code, $this->providerKey));

        $this->assertInstanceOf('OpenSky\Bundle\GigyaBundle\Security\Authentication\Token\GigyaToken', $gigya);
        $this->assertSame($account, $gigya->getUser());
    }

    private function getMockToken()
    {
        return $this->getMock('Symfony\Component\Security\Core\Authentication\Token\TokenInterface');
    }

    private function getMockAccount()
    {
        return $this->getMock('Symfony\Component\Security\Core\User\UserInterface');
    }

    private function getSocializerMock()
    {
        return $this->getMock('OpenSky\Bundle\GigyaBundle\Socializer\SocializerInterface');
    }

    private function getMockUserProvider()
    {
        return $this->getMock('Symfony\Component\Security\Core\User\UserProviderInterface');
    }

    private function getMockAccountChecker()
    {
        return $this->getMock('Symfony\Component\Security\Core\User\UserCheckerInterface');
    }
}