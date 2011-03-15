<?php

namespace OpenSky\Bundle\GigyaBundle\Security\Firewall;

use OpenSky\Bundle\GigyaBundle\Security\Authentication\Token\GigyaToken;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Firewall\AbstractAuthenticationListener;

class GigyaListener extends AbstractAuthenticationListener
{
    protected function attemptAuthentication(Request $request)
    {
        return $this->authenticationManager->authenticate(new GigyaToken());
    }
}
