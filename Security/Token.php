<?php

namespace OpenSky\Bundle\GigyaBundle\Security;

class Token
{
    private $accessToken;
    private $expiresIn;
    private $state;

    public function __construct($accessToken, $expiresIn, $state = null)
    {
        $this->accessToken = $accessToken;
        $this->expiresIn = $expiresIn;
        $this->state = $state;
    }

    /**
     * @return string $accessToken
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @return int $expiresIn
     */
    public function getExpiresIn()
    {
        return $this->expiresIn;
    }

    /**
     * @return string $state
     */
    public function getState()
    {
        return $this->state;
    }
}
