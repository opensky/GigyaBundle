<?php

namespace OpenSky\Bundle\GigyaBundle\Socializer;

interface SocializerInterface
{
    function getApiKey();
    function getProviders();
    function hasUserActionByKey($key);
    function getUserActionByKey($key);
    function addUserActionByKey($userAction, $key);
    function login($provider);
    function getAccessToken($code = null, $params = array());
    function getUser($token);
    function getSessionInfo($uid, $provider);
    function notifyRegistration($token, $uid, $id, $message = null);
    function deleteAccount($token, $id, $message = null);
}
