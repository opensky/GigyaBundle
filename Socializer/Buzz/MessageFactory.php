<?php

namespace OpenSky\Bundle\GigyaBundle\Socializer\Buzz;

use Buzz\Message\Request;

class MessageFactory
{
    private $key;
    private $host;
    private $redirect;

    public function __construct($key, $host, $redirect)
    {
        $this->key      = $key;
        $this->host     = $host;
        $this->redirect = $redirect;
    }

    public function getLoginMessage($provider)
    {
        $request = new Request(Request::METHOD_POST, '/socialize.login', $this->host);

        $request->setContent(http_build_query(array(
            'x_provider'    => $provider,
            'client_id'     => $this->key,
            'redirect_uri'  => $this->redirect,
            'response_type' => 'token'
        )));

        return $request;
    }
}
