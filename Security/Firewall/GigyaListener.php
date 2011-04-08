<?php

namespace OpenSky\Bundle\GigyaBundle\Security\Firewall;

use OpenSky\Bundle\GigyaBundle\Security\Authentication\Token\GigyaToken;
use OpenSky\Bundle\GigyaBundle\Socializer\Buzz\MessageFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Firewall\AbstractAuthenticationListener;

class GigyaListener extends AbstractAuthenticationListener
{
    private $factory;

    public function setMessageFactory(MessageFactory $factory)
    {
        $this->factory = $factory;
    }

    protected function attemptAuthentication(Request $request)
    {
//        die('asdsa');
        $code = $request->query->get('code');
        if (null !== $code) {
            $this->factory->setRedirectUri($request->getUriForPath($request->getPathInfo()));

            return $this->authenticationManager->authenticate(new GigyaToken('', $code, $this->providerKey));
        }
    }
}
