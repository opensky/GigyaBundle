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

    public function getAccessTokenRequest($code = null)
    {
        $request = new Request(Request::METHOD_POST, '/socialize.getToken?client_id='.$this->key.'&client_secret='.$this->secret, $this->host);

        if (null !== $code) {
            $request->setContent(http_build_query(array(
                'grant_type'   => 'authorization_code',
                'code'         => $code,
                'redirect_uri' => $this->redirectUri,
            )));
        } else {
            $request->setContent(http_build_query(array(
                'grant_type'   => 'none',
            )));
        }

        return $request;
    }

    public function getUserInfoRequest($token)
    {
        $request = new Request(Request::METHOD_POST, '/socialize.getUserInfo?'.http_build_query(array(
            'apiKey'      => $this->key,
            'secret'      => $this->secret,
            'oauth_token' => $token,
            'nonce'       => $token,
            'timestamp'   => time(),
        )), $this->host);

        $request->setContent(http_build_query(array(
            'format' => 'xml',
        )));

        return $request;
    }

    public function getSetUIDRequest($token, $uid, $id)
    {
        $request = new Request(Request::METHOD_POST, '/socialize.setUID?'.http_build_query(array(
            'uid'       => $uid,
            'apiKey'    => $this->key,
            'secret'    => $this->secret,
            'nonce'     => $token,
            'timestamp' => time(),
        )), $this->host);

        $request->setContent(http_build_query(array(
            'siteUID' => $id,
            'format'  => 'xml',
        )));

        return $request;
    }

    public function getUserInfoReloadRequest($uid)
    {
        $request = new Request(Request::METHOD_POST, '/socialize.getUserInfo?apiKey='.$this->key.'&secret='.$this->secret.'&uid='.$uid, $this->host);

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
