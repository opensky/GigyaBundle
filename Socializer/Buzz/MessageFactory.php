<?php

namespace OpenSky\Bundle\GigyaBundle\Socializer\Buzz;

use Buzz\Message\Response;

use Buzz\Message\Request;
use Symfony\Component\Routing\RouterInterface;

class MessageFactory
{
    private $key;
    private $host;
    private $secret;
    private $redirectUri;
    private $code;

    public function __construct($key, $secret, $host)
    {
        $this->key      = $key;
        $this->secret   = $secret;
        $this->host     = $host;
    }

    public function setRedirectUri($redirectUri)
    {
        $this->redirectUri = $redirectUri;
    }

    public function getLoginRequest($provider)
    {
        $request = new Request(Request::METHOD_POST, '/socialize.login', $this->host);

        $request->setContent(http_build_query(array(
            'x_provider'    => $provider,
            'client_id'     => $this->key,
            'redirect_uri'  => $this->redirectUri,
            'response_type' => 'code'
        )));

        return $request;
    }

    public function setCode($code)
    {
        $this->code = $code;
    }

    public function getAccessTokenRequest()
    {
        $request = new Request(Request::METHOD_POST, '/socialize.getToken?client_id='.$this->key.'&client_secret='.$this->secret, $this->host);

        $request->setContent(http_build_query(array(
            'grant_type'   => 'authorization_code',
            'code'         => $this->code,
            'redirect_uri' => $this->redirectUri,
        )));

        return $request;
    }

    public function getUserInfoRequest($token)
    {
        $request = new Request(Request::METHOD_POST, '/socialize.getUserInfo?apiKey='.$this->key.'&secret='.$this->secret.'&oauth_token='.$token, $this->host);

        $request->setContent(http_build_query(array(
            'format' => 'xml',
        )));

        return $request;
    }

    public function getResponse()
    {
        return new Response();
    }
}
