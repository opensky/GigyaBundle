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

    public function getDeleteAccountRequest($token, $id, $message = null)
    {
        $request = new Request(Request::METHOD_POST, '/socialize.deleteAccount?'.http_build_query(array(
            'uid'       => $id,
            'apiKey'    => $this->key,
            'secret'    => $this->secret,
            'nonce'     => $token,
            'timestamp' => time(),
        )), $this->host);

        $data = array(
            'uid' => $id,
        );

        if (null !== $message) {
            $data['cid'] = $message;
        }

        $request->setContent(http_build_query($data));

        return $request;
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

    public function getUserInfoRequest($token, $uid = null)
    {
        $query = array(
            'apiKey'      => $this->key,
            'secret'      => $this->secret,
            'nonce'       => $token,
            'timestamp'   => time(),
        );

        if (null !== $uid) {
            $query['uid'] = $uid;
        } else {
            $query['oauth_token'] = $token;
        }

        $request = new Request(Request::METHOD_POST, '/socialize.getUserInfo?'.http_build_query($query), $this->host);

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

    public function getNotifyRegistrationRequest($token, $uid, $id, $message = null)
    {
        $request = new Request(Request::METHOD_POST, '/socialize.notifyRegistration?'.http_build_query(array(
            'uid'       => $uid,
            'apiKey'    => $this->key,
            'secret'    => $this->secret,
            'nonce'     => $token,
            'timestamp' => time(),
        )), $this->host);

        $data = array(
            'siteUID' => $id,
            'format'  => 'xml',
        );

        if (null !== $message) {
            $data['cid'] = $message;
        }

        $request->setContent(http_build_query($data));

        return $request;
    }

    public function getNotifyLoginRequest($token, $id, $newUser = false, $message = null, $userInfo = null)
    {
        $request = new Request(Request::METHOD_POST, '/socialize.notifyRegistration?'.http_build_query(array(
            'apiKey'    => $this->key,
            'secret'    => $this->secret,
            'nonce'     => $token,
            'timestamp' => time(),
        )), $this->host);

        $data = array(
            'siteUID' => $id,
            'newUser' => $newUser,
        );

        if (null !== $message) {
            $data['cid'] = $message;
        }

        if (null !== $userInfo) {
            $data['userInfo'] = json_encode($userInfo);
        }

        $request->setContent(http_build_query($data));

        return $request;
    }

    public function getRemoveConnectionRequest($token, $uid, $provider = null)
    {
        $request = new Request(Request::METHOD_POST, '/socialize.disconnect?'.http_build_query(array(
            'uid'       => $uid,
            'apiKey'    => $this->key,
            'secret'    => $this->secret,
            'nonce'     => $token,
            'timestamp' => time(),
        )), $this->host);

        $data = array(
            'format'  => 'xml',
        );

        if (null !== $provider) {
            $data['provider'] = $provider;
        }

        $request->setContent(http_build_query($data));

        return $request;
    }

    public function getSessionInfoRequest($uid, $provider)
    {
        return new Request(Request::METHOD_GET, '/socialize.getSessionInfo?'.http_build_query(array(
            'provider' => $provider,
            'uid'      => $uid,
            'apiKey'   => $this->key,
            'secret'   => $this->secret,
        )), $this->host);
    }

    public function getResponse()
    {
        return new Response();
    }
}
