<?php

namespace OpenSky\Bundle\GigyaBundle\Security\Core\User;

use Symfony\Component\Security\Core\Role\RoleInterface;
use Symfony\Component\Security\Core\User\AccountInterface;

abstract class AbstractUser implements AccountInterface
{
    protected $password;
    protected $providers = array();
    protected $salt;
    protected $username;

    /**
     * {@inheritDoc}
     */
    public function getRoles()
    {

    }

    /**
     * {@inheritDoc}
     * @return string $password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * {@inheritDoc}
     * @return string $salt
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * {@inheritDoc}
     * @return string $username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * {@inheritDoc}
     */
    public function eraseCredentials()
    {

    }

    /**
     * {@inheritDoc}
     */
    public function equals(AccountInterface $account)
    {
        return true;
    }

    /**
     * @return array $providers
     */
    public function getProviders()
    {
        return $this->providers;
    }

    /**
     * @param array $providers
     */
    public function setProviders(array $providers)
    {
        $this->providers = $providers;
    }
}
