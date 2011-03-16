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
        if (null !== $request->query->get('code')) {
            $this->factory->setRedirectUri($request->getUriForPath($request->getPathInfo()));
            $this->factory->setCode($request->query->get('code'));

            return $this->authenticationManager->authenticate(new GigyaToken());
        }
    }
}
