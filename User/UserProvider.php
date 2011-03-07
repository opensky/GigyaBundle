<?php

namespace OpenSky\Bundle\GigyaBundle\User;

use OpenSky\Bundle\GigyaBundle\Socializer;
use Symfony\Component\Security\Core\User\AccountInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
    private $socializer;

    public function __construct(Socializer $socializer)
    {
        $this->socializer = $socializer;
    }

    public function loadUserByUsername($username)
    {

    }

    public function loadUserByAccount(AccountInterface $account)
    {

    }

    public function supportsClass($class)
    {

    }
}
