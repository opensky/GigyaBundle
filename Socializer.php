<?php

namespace AntiMattr\GigyaBundle;

use AntiMattr\GigyaBundle\Socializer\UserAction;

class Socializer
{
    const SIMPLE_SHARE = 'simpleShare';
    const MULTI_SELECT = 'multiSelect';

    private $apiKey;
    private $namespace;
    private $userActions = array();

    static public $shareChoices = array(
        self::SIMPLE_SHARE => 'Simple Share',
        self::MULTI_SELECT => 'Multi Select',
    );

    /**
     * @param string $share
     * @return boolean $isShareValid
     */
    static public function isShareValid($share)
    {
		return array_key_exists($share, static::$shareChoices);
	}

    public function __construct($apiKey, $namespace = 'window')
    {
        $this->apiKey = (string) $apiKey;
        $this->namespace = (string) $namespace;
    }

    /**
     * @return string $apiKey
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @return string $namespace
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @param string $key
     * @return boolean $hasUserActionByKey
     */
    public function hasUserActionByKey($key)
    {
        return array_key_exists($key, $this->userActions);
    }

    /**
     * @param string $key
     * @return UserAction $userAction
     */
    public function getUserActionByKey($key)
    {
        return $this->userActions[$key];
    }

    /**
     * @param UserAction $userAction
     * @param string $key
     */
    public function addUserActionByKey($userAction, $key)
    {
        $this->userActions[$key] = $userAction;
    }
}
