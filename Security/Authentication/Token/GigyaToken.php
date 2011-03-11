<?php

namespace OpenSky\Bundle\GigyaBundle\Security\Authentication\Token;

use Symfony\Component\Security\Core\Authentication\Token\Token;

class GigyaToken extends Token
{
    private $accessToken;
    private $expires;

    public function __construct($accessToken, \DateTime $expires = null)
    {
        $this->accessToken   = $accessToken;
        $this->authenticated = true;
        $this->expires       = $expires;
    }

    public function getRoles()
    {
        return 'GIGYA';
    }

    /**
     * {@inheritdoc}
     */
    public function serialize()
    {
        $parameters = array($this->user, $this->credentials, $this->authenticated, $this->roles, $this->immutable, $this->providerKey, $this->attributes, $this->accessToken);

        if (null !== $this->expires) {
            $parameters[] = $this->expires->getTimestamp();
        }

        return serialize($parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized)
    {
        $parameters = unserialize($serialized);

        list($this->user, $this->credentials, $this->authenticated, $this->roles, $this->immutable, $this->providerKey, $this->attributes, $this->accessToken) = $parameters;

        if (count($parameters) === 9) {
            $this->expires = new \DateTime();
            $this->expires->setTimestamp($parameters[8]);
        }
    }
}
