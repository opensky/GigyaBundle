<?php

namespace OpenSky\Bundle\GigyaBundle\Socializer;

use Symfony\Component\Security\Core\User\User;

interface SocializerInterface
{
    function getApiKey();
    function getProviders();
    function hasUserActionByKey($key);
    function getUserActionByKey($key);
    function addUserActionByKey($userAction, $key);
    function login($provider);
    function getAccessToken($code = null, $params = array());

    /**
     * @param $token
     * @return User
     */
    function getUser($token);
    function getSessionInfo($uid, $provider);
    function notifyRegistration($token, $uid, $id, $message = null);
    function deleteAccount($token, $id, $message = null);
    function getFriendsInfo($token, $uid, $params = array());
    function notifyLogin($token, $id, $newUser = false, $message = null, $userInfo = null);
    function publishUserActionByKey($key, $uid, $token, $enabledProviders = null, $disabledProviders = null, $target = null, $userLocation = null, $shortURLs = null, $tags = null);
    function setUserInfo($token, $userData);
    function setUserId($token, $uid, $id);
    function removeConnection($token, $uid, $provider = null);
    function getGMchallengeStatus($token, $id, $details = null, $include = null, $exclude = null);
    function notifyAction($token, $uid, $action);
    function getGMredeemPoints($token, $id, $points);
    function getUserInfo($token, $uid = null);

    /**
     * get comments from gigya
     * @param $token
     * @param array $params
     * @return mixed
     */
    function getComments($token, $params = array());
}
