<?php

namespace OpenSky\Bundle\GigyaBundle\Socializer\Buzz;

use Buzz\Message\Response;

use Buzz\Message\Request;
use Symfony\Component\Routing\RouterInterface;

class MessageFactory
{
    private $router;
    private $key;
    private $host;
    private $redirect;

    public function __construct(RouterInterface $router, $key, $host, $redirect)
    {
        $this->router   = $router;
        $this->key      = $key;
        $this->host     = $host;
        $this->redirect = $redirect;
    }

    public function getLoginRequest($provider)
    {
        $request = new Request(Request::METHOD_POST, '/socialize.login', $this->host);

        $request->setContent(http_build_query(array(
            'x_provider'    => $provider,
            'client_id'     => $this->key,
            'redirect_uri'  => $this->router->generate($this->redirect, array()),
            'response_type' => 'token'
        )));

        return $request;
    }

    public function getResponse()
    {
        return new Response();
    }
}
