<?php

namespace OpenSky\Bundle\GigyaBundle\Security\Firewall;

use OpenSky\Bundle\GigyaBundle\Security\Authentication\Token\GigyaToken;
use OpenSky\Bundle\GigyaBundle\Socializer\Buzz\MessageFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Firewall\AbstractAuthenticationListener;

class GigyaListener extends AbstractAuthenticationListener
{
    /**
     * @var OpenSky\Bundle\GigyaBundle\Socializer\Buzz\MessageFactory
     */
    private $factory;

    /**
     * @var Symfony\Component\Routing\RouterInterface
     */
    private $router;

    /**
     * @var string
     */
    private $route;

    /**
     * @param OpenSky\Bundle\GigyaBundle\Socializer\Buzz\MessageFactory $factory
     * @param string                                                    $route
     */
    public function setMessageFactory(MessageFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @param Symfony\Component\Routing\RouterInterface $router
     */
    public function setRouter(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @param string $route
     */
    public function setRoute($route)
    {
        $this->route = $route;
    }

    protected function attemptAuthentication(Request $request)
    {
        $code = $request->query->get('code');

        if (null !== $code) {
            if ($this->route) {
                $this->factory->setRedirectUri($this->router->generate($this->route, array(), true));
            }

            return $this->authenticationManager->authenticate(new GigyaToken('', $code, $this->providerKey));
        }
    }
}
