<?php

namespace OpenSky\Bundle\GigyaBundle\Security\Authentication\Token;

use Symfony\Component\Security\Core\Authentication\Token\Token;

class GigyaToken extends Token
{
    public function __construct($user = '', array $roles = array())
    {
        $this->user = $user;

        parent::__construct($roles);
    }
}
