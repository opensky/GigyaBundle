<?php

namespace OpenSky\Bundle\GigyaBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class GigyaEvent extends Event
{
    private $provider;
    private $uid;

    public function __construct($provider, $uid)
    {
        $this->provider = $provider;
        $this->uid = $uid;
    }

    public function getProvider()
    {
        return $this->provider;
    }

    public function getUid()
    {
        return $this->uid;
    }
}
