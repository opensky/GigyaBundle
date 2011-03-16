<?php

namespace OpenSky\Bundle\GigyaBundle\Security\Authentication\Token;

use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;

class GigyaToken extends AbstractToken
{
    public function __construct($user = '', array $roles = array())
    {
        $this->setUser($user);
        parent::__construct($roles);

        if (!empty($user)) {
            $this->setAuthenticated(true);
        }
    }

    public function getCredentials()
    {
        return $this->getUser();
    }
}
