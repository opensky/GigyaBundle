<?php

namespace OpenSky\Bundle\GigyaBundle\Document;

use OpenSky\Bundle\GigyaBundle\Security\Core\User\AbstractUser;
use Symfony\Component\Security\Core\User\AccountInterface;

/**
 * @mongodb:Document(
 *     collection="users",
 *     repositoryClass="OpenSky\Bundle\GigyaBundle\Document\UserRepository",
 * )
 */
class User extends AbstractUser
{
    /** @mongodb:String */
    protected $password;

    /** @mongodb:Hash */
    protected $providers = array();

    /** @mongodb:String */
    protected $username;

    public function equals(AccountInterface $accountInterface)
    {

    }
}
