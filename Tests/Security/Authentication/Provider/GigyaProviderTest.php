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
        $this->socializer = $this->getSocializerMock();
        $this->provider = new GigyaProvider($this->socializer);
    }

    public function testShouldSupportGigyaTokenOnly()
    {
        $this->assertTrue($this->provider->supports(new GigyaToken()));
        $this->assertFalse($this->provider->supports($this->getMockToken()));
    }

    /**
     * @expectedException Symfony\Component\Security\Core\Exception\UnsupportedUserException
     */
    public function testShouldNotLoadUserByAccount()
    {
        $this->provider->loadUserByAccount($this->getMockAccount());
    }

    public function testShouldNotAuthenticateIfUnsuportedToken()
    {
        $this->assertNull($this->provider->authenticate($this->getMockToken()));
    }

    public function testShouldAuthenticateWithAccessTokenAndNoUserProvider()
    {
        $userId      = '123';
        $token       = 'test';
        $accessToken = array('access_token' => $token);

        $this->socializer->expects($this->once())
            ->method('getAccessToken')
            ->will($this->returnValue($accessToken));

        $this->socializer->expects($this->once())
            ->method('getUserId')
            ->with($token)
            ->will($this->returnValue($userId));

        $gigya = $this->provider->authenticate(new GigyaToken());

        $this->assertInstanceOf('OpenSky\Bundle\GigyaBundle\Security\Authentication\Token\GigyaToken', $gigya);
        $this->assertEquals($userId, $gigya->getUser());
    }

    public function testShouldAuthenticateWithAccessTokenAndUserProvider()
    {
        $userId      = '123';
        $token       = 'test';
        $accessToken = array('access_token' => $token);
        $user        = $this->getMockAccount();

        $user->expects($this->once())
            ->method('getRoles')
            ->will($this->returnValue(array()));

        $provider = $this->getMockUserProvider();
        $checker  = $this->getMockAccountChecker();

        $gigyaProvider = new GigyaProvider($this->socializer, $provider, $checker);

        $this->socializer->expects($this->once())
            ->method('getAccessToken')
            ->will($this->returnValue($accessToken));

        $this->socializer->expects($this->once())
            ->method('getUserId')
            ->with($token)
            ->will($this->returnValue($userId));

        $provider->expects($this->once())
            ->method('loadUserByUsername')
            ->with($userId)
            ->will($this->returnValue($user));

        $checker->expects($this->once())
            ->method('checkPreAuth')
            ->with($user);

        $checker->expects($this->once())
            ->method('checkPostAuth')
            ->with($user);

        $gigya = $gigyaProvider->authenticate(new GigyaToken());

        $this->assertInstanceOf('OpenSky\Bundle\GigyaBundle\Security\Authentication\Token\GigyaToken', $gigya);
        $this->assertEquals($user, $gigya->getUser());
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