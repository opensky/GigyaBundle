<?php

namespace OpenSky\Bundle\GigyaBundle\Controller;

use OpenSky\Bundle\GigyaBundle\Socializer\Buzz\MessageFactory;
use OpenSky\Bundle\GigyaBundle\Socializer\Socializer;
use OpenSky\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

class GigyaController
{
    /**
     * @var OpenSky\Bundle\GigyaBundle\Socializer\Socializer
     */
    private $socializer;

    /**
     * @var OpenSky\Bundle\GigyaBundle\Socializer\Buzz\MessageFactory
     */
    private $messages;

    /**
     * @var Symfony\Component\Routing\RouterInterface
     */
    private $router;

    /**
     * @var string
     */
    private $route;

    /**
     * @param OpenSky\Bundle\GigyaBundle\Socializer\Socializer          $socializer
     * @param OpenSky\Bundle\GigyaBundle\Socializer\Buzz\MessageFactory $messages
     * @param Symfony\Component\Routing\RouterInterface                 $router
     * @param string                                                    $route
     */
    public function __construct(Socializer $socializer, MessageFactory $messages, RouterInterface $router, $route)
    {
        $this->socializer = $socializer;
        $this->messages   = $messages;
        $this->router     = $router;
        $this->route      = $route;
    }

    public function login($provider)
    {
        $this->messages->setRedirectUri($this->router->generate($this->route, array(), true));

        $message = $this->socializer->login($provider);

        return new Response($message->getContent(), $message->getStatusCode(), $message->getHeaders());
    }
}
