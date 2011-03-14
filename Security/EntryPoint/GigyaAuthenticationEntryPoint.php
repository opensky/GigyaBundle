<?php

namespace OpenSky\Bundle\GigyaBundle\Security\EntryPoint;

use Symfony\Component\EventDispatcher\EventInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;
use Symfony\Component\Templating\EngineInterface;

class GigyaAuthenticationEntryPoint implements AuthenticationEntryPointInterface
{
    /**
     * @var Symfony\Component\Templating\EngineInterface
     */
    private $engine;

    public function __construct(EngineInterface $engine)
    {
        $this->engine = $engine;
    }

    public function start(EventInterface $event, Request $request, AuthenticationException $authException = null)
    {
        return $this->engine->render('GigyaBundle:Example:login_popup.html.twig', array());
    }

}
