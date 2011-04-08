<?php

namespace OpenSky\Bundle\GigyaBundle\Security\Authentication\Token;

use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;

class GigyaToken extends AbstractToken
{
    private $credentials;
    private $providerKey;

    /**
     * Constructor.
     *
     * @param string $user The username (like a nickname, email address, etc.)
     * @param string $credentials This usually is the password of the user
     */
    public function __construct($user, $credentials, $providerKey, array $roles = array())
    {
        parent::__construct($roles);

        if (empty($providerKey)) {
            throw new \InvalidArgumentException('$providerKey must not be empty.');
        }

        $this->setUser($user);
        $this->credentials = $credentials;
        $this->providerKey = $providerKey;

        if (!empty($user)) {
            $this->setAuthenticated(true);
        }
    }

    public function getCredentials()
    {
        return $this->credentials;
    }

    public function getProviderKey()
    {
        return $this->providerKey;
    }

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials()
    {
        parent::eraseCredentials();

        $this->credentials = null;
    }

    public function serialize()
    {
        return serialize(array($this->credentials, $this->providerKey, parent::serialize()));
    }

    public function unserialize($str)
    {
        list($this->credentials, $this->providerKey, $parentStr) = unserialize($str);
        parent::unserialize($parentStr);
    }

    public function setUser($user)
    {
        parent::setUser($user);

        $this->setAuthenticated(true);
    }
}
