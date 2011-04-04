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
    function getAccessToken();
    function getUser($token);
}
