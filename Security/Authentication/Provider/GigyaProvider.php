<?php
namespace OpenSky\Bundle\GigyaBundle\Security\Authentication\Provider;

use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

use Symfony\Component\HttpFoundation\Request;
use OpenSky\Bundle\GigyaBundle\Security\Authentication\Token\GigyaToken;
use OpenSky\Bundle\GigyaBundle\Socializer\SocializerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;

class GigyaProvider implements AuthenticationProviderInterface
{
    private $socializer;
    private $providerKey;
    private $accessToken;
    private $userProvider;
    private $userChecker;

    public function __construct(SocializerInterface $socializer, $providerKey, UserProviderInterface $userProvider = null, UserCheckerInterface $userChecker = null)
    {
        if (null !== $userProvider && null === $userChecker) {
            throw new \InvalidArgumentException('$accountChecker cannot be null, if $userProvider is not null.');
        }

        $this->socializer   = $socializer;
        $this->providerKey  = $providerKey;
        $this->userProvider = $userProvider;
        $this->userChecker  = $userChecker;
    }

    public function authenticate(TokenInterface $token)
    {
        if (!$this->supports($token)) {
            return null;
        }
        try {
            $accessToken  = $this->socializer->getAccessToken();
            if (null !== $accessToken) {
                $user = $this->socializer->getUser($accessToken['access_token'], $token->getCredentials());

                return $this->createAuthenticatedToken($user);
            }
        } catch (AuthenticationException $failed) {
            throw $failed;
        } catch (\Exception $failed) {
            throw new AuthenticationException('Unknown error', $failed->getMessage(), $failed->getCode(), $failed);
        }

        throw new AuthenticationException('The Gigya user could not be retrieved from the session.');
    }

    public function supports(TokenInterface $token)
    {
        return $token instanceof GigyaToken && $this->providerKey === $token->getProviderKey();
    } 

    private function createAuthenticatedToken(UserInterface $user)
    {
        $token = new GigyaToken($user, '', $this->providerKey, $user->getRoles());
        if (null === $this->userProvider) {
            return $token;
        }

        try {
            $loaded = $this->userProvider->loadUserByUsername($user->getUsername());
            
            if (! $loaded instanceof UserInterface) {
                throw new \RuntimeException('User provider did not return an implementation of account interface.');
            }

        } catch (UsernameNotFoundException $e) {
            return $token;
        }

        $this->userChecker->checkPreAuth($loaded);
        $this->userChecker->checkPostAuth($loaded);

        return new GigyaToken($loaded, $loaded->getPassword(), $this->providerKey, $loaded->getRoles());
    }
}
