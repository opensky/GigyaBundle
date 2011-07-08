<?php

namespace OpenSky\Bundle\GigyaBundle\Controller;

use OpenSky\Bundle\GigyaBundle\Events;
use OpenSky\Bundle\GigyaBundle\Event\GigyaEvent;
use OpenSky\Bundle\GigyaBundle\Socializer\Buzz\MessageFactory;
use OpenSky\Bundle\GigyaBundle\Socializer\Socializer;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

class GigyaController
{
    /**
     * @var Symfony\Component\HttpFoundation\Request
     */
    private $request;

    /**
     * @var Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    private $dispatcher;

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
     * @param Symfony\Component\HttpFoundation\Request                   $request
     * @param Symfony\Component\EventDispatcher\EventDispatcherInterface $dispatcher
     * @param OpenSky\Bundle\GigyaBundle\Socializer\Socializer           $socializer
     * @param OpenSky\Bundle\GigyaBundle\Socializer\Buzz\MessageFactory  $messages
     * @param Symfony\Component\Routing\RouterInterface                  $router
     * @param string                                                     $route
     */
    public function __construct(Request $request, EventDispatcherInterface $dispatcher, Socializer $socializer, MessageFactory $messages, RouterInterface $router, $route)
    {
        $this->request    = $request;
        $this->dispatcher = $dispatcher;
        $this->socializer = $socializer;
        $this->messages   = $messages;
        $this->router     = $router;
        $this->route      = $route;
    }

    public function login($provider)
    {
        if (null !== ($redirect = $this->request->get('redirect'))) {
            $this->request->getSession()->set('_security.target_path', $redirect);
        }

        $this->messages->setRedirectUri($this->router->generate($this->route, array(), true));

        $message = $this->socializer->login($provider);

        return new Response($message->getContent(), $message->getStatusCode(), $message->getHeaders());
    }

    public function unlink($uid)
    {
        $provider = $this->request->request->get('provider');
        $this->socializer->removeConnection($this->socializer->getAccessToken(), $uid, $provider);

        $this->dispatcher->dispatch(Events::onGigyaUnlink, new GigyaEvent($provider, $uid));

        if (null !== ($redirect = $this->request->get('redirect'))) {
            return new RedirectResponse($redirect);
        }

        return new Response();
    }
}
