<?php

namespace OpenSky\Bundle\GigyaBundle\Socializer\Buzz;

use Buzz\Message\Response;
use Buzz\Message\Request;
use OpenSky\Bundle\GigyaBundle\Socializer\UserAction;

class MessageFactory
{
    private $key;
    private $host;
    private $gmhost;
    private $secret;
    private $redirectUri;
    private $commenthost;

    public function __construct($key, $secret, $host, $gmhost, $commenthost)
    {
        $this->key              = $key;
        $this->secret           = $secret;
        $this->host             = $host;
        $this->gmhost           = $gmhost;
        $this->commenthost      = $commenthost;
    }

    public function setRedirectUri($redirectUri)
    {
        $this->redirectUri = $redirectUri;
    }

    public function getDeleteAccountRequest($token, $id, $message = null)
    {
        $request = new Request(Request::METHOD_POST, '/socialize.deleteAccount?'.http_build_query(array(
            'apiKey'    => $this->key,
            'secret'    => $this->secret,
            'nonce'     => $token,
            'timestamp' => time(),
        )), $this->host);

        $data = array(
            'uid' => $id
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

        $data = array(
            'x_provider'    => $provider,
            'client_id'     => $this->key,
            'response_type' => 'code'
        );
        if ($this->redirectUri) {
            $data['redirect_uri'] = $this->redirectUri;
        }
        $request->setContent(http_build_query($data));

        return $request;
    }

    public function getAccessTokenRequest($code = null, $params = array())
    {
        $request = new Request(Request::METHOD_POST, '/socialize.getToken?client_id='.$this->key.'&client_secret='.$this->secret, $this->host);

        if (null !== $code) {
            $data = array(
                'grant_type'   => 'authorization_code',
                'code'         => $code,
            );
            if ($this->redirectUri) {
                $data['redirect_uri'] = $this->redirectUri;
            }
            $request->setContent(http_build_query($data));
        } else {
            $query_params = array_merge(array('grant_type' => 'none'), $params);
            $request->setContent(http_build_query($query_params));
        }

        return $request;
    }

    public function setUserInfoRequest($token, $userData)
    {
        $query = array(
            'apiKey'      => $this->key,
            'secret'      => $this->secret,
            'nonce'       => $token,
            'timestamp'   => time(),
            'uid'         => $userData['id']
        );
        unset($userData['id']);
        $query['userinfo'] = json_encode($userData);

        $request = new Request(Request::METHOD_POST, '/socialize.setUserInfo?'.http_build_query($query), $this->host);

        $request->setContent(http_build_query(array(
            'format' => 'xml',
        )));

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
        $request = new Request(Request::METHOD_POST, '/socialize.notifyLogin?'.http_build_query(array(
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

    public function getGMredeemPoints($token, $uid, $redeemPoints) {
        $request = new Request(Request::METHOD_POST, '/gm.redeemPoints?'.http_build_query(array(
            'apiKey'    => $this->key,
            'secret'    => $this->secret,
            'nonce'     => $token,
            'timestamp' => time(),
        )), $this->gmhost);

        $data = array(
            "UID"      => $uid,
            "challenge"=>"_default",
            "points"   =>$redeemPoints
        );

        $request->setContent(http_build_query($data));
        return $request;
    }

    public function getGMchallengeStatusRequest($token, $uid, $details = null, $include = null, $exclude = null)
    {
        $request = new Request(Request::METHOD_POST, '/gm.getChallengeStatus?'.http_build_query(array(
            'apiKey'    => $this->key,
            'secret'    => $this->secret,
            'nonce'     => $token,
            'timestamp' => time(),
        )), $this->gmhost);

        $data = array(
            'uid'   => $uid,
        );

        if (null != $details) {
            $data['details'] = 'full';
        }

        if (null !== $include) {
            $data['includeChallenges'] = $include;
        }

        if (null !== $exclude) {
            $data['excludeChallenges'] = $exclude;
        }

        $request->setContent(http_build_query($data));

        return $request;
    }
    public function getNotifyActionRequest($token, $uid, $action)
    {
        $request = new Request(Request::METHOD_POST, '/gm.notifyAction?'.http_build_query(array(
            'apiKey'    => $this->key,
            'secret'    => $this->secret,
            'nonce'     => $token,
            'timestamp' => time(),
        )), $this->gmhost);

        $data = array(
            'uid'   => $uid,
            'action'   => $action,
        );

        $request->setContent(http_build_query($data));

        return $request;
    }

    /**
     * @param $uid
     * @param $token
     * @param $userAction UserAction
     * @param null $enabledProviders
     * @param null $disabledProviders
     * @param null $target
     * @param null $userLocation
     * @param null $shortURLs
     * @param null $tags
     * @return Request
     */
    public function getPublishUserActionRequest($uid, $token, $userAction, $enabledProviders = null, $disabledProviders = null, $target = null, $userLocation = null, $shortURLs = null, $tags = null) {
        $request = new Request(Request::METHOD_POST, '/socialize.publishUserAction?'.http_build_query(array(
            'apiKey'    => $this->key,
            'secret'    => $this->secret,
            'nonce'     => $token,
            'timestamp' => time(),
        )), $this->host);

        $data = array(
            'uid'   => $uid,
        );

        if (null !== $enabledProviders) {
            $data['enabledProviders'] = $enabledProviders;
        }

        if (null !== $disabledProviders) {
            $data['disabledProviders'] = $disabledProviders;
        }

        if (null !== $target) {
            $data['target'] = $target;
        }

        if (null !== $userLocation) {
            $data['userLocation'] = $userLocation;
        }

        if (null !== $shortURLs) {
            $data['shortURLs'] = $shortURLs;
        }

        if (null !== $tags) {
            $data['tags'] = $tags;
        }

        $data['userAction'] = $userAction->toJson();

        $request->setContent(http_build_query($data));
        return $request;
    }

    public function getFriendsInfoRequest($token, $uid, $params = array()) {
        $request = new Request(Request::METHOD_POST, '/socialize.getFriendsInfo?'.http_build_query(array(
            'apiKey'      => $this->key,
            'secret'      => $this->secret,
            'nonce'     => $token,
            'timestamp' => time(),
            'uid'      => $uid
        )), $this->host);

        $data = array();
        foreach ($params as $key => $value) {
            $data[$key] = $value;
        }

        $request->setContent(http_build_query($data));
        return $request;
    }

    public function getCommentRequst($token, $params = array()) {
        $request = new Request(Request::METHOD_POST, '/comments.getComments?'.http_build_query(array(
            'apiKey'      => $this->key,
            'secret'      => $this->secret,
            'nonce'     => $token,
            'timestamp' => time()
        )), $this->commenthost);

        $data = array();
        foreach ($params as $key => $value) {
            $data[$key] = $value;
        }

        $request->setContent(http_build_query($data));
        return $request;
    }
}
