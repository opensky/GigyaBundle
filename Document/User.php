<?php

namespace OpenSky\Bundle\GigyaBundle\Document;

use OpenSky\Bundle\GigyaBundle\User\AbstractUser;

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

}
