<?php

namespace OpenSky\Bundle\GigyaBundle\Controller;

use OpenSky\Bundle\GigyaBundle\Socializer\Socializer;

use OpenSky\Component\HttpFoundation\Response;

class GigyaController
{
    /**
     * @var OpenSky\Bundle\GigyaBundle\Socializer\Socializer
     */
    private $socializer;

    public function __construct(Socializer $socializer)
    {
        $this->socializer = $socializer;
    }

    public function login($provider)
    {
        $message = $this->socializer->login($provider);

        return new Response($message->getContent(), $message->getStatusCode(), $message->getHeaders());
    }
}
