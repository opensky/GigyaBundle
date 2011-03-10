<?php

namespace OpenSky\Bundle\GigyaBundle\Socializer;

use Buzz\Message\Response;

use Buzz\Client\ClientInterface;
use OpenSky\Bundle\GigyaBundle\Socializer\Buzz\MessageFactory;
use OpenSky\Bundle\GigyaBundle\Socializer\UserAction;

class Socializer
{
    const SIMPLE_SHARE = 'simpleShare';
    const MULTI_SELECT = 'multiSelect';

    static public $shareChoices = array(
        self::SIMPLE_SHARE => 'Simple Share',
        self::MULTI_SELECT => 'Multi Select',
    );

    private $apiKey;
    private $providers = array();
    private $userActions = array();
    private $client;
    private $factory;

    public function __construct($apiKey, array $providers = array(), ClientInterface $client, MessageFactory $factory)
    {
        $this->apiKey  = (string) $apiKey;
        $this->providers = $providers;
        $this->client  = $client;
        $this->factory = $factory;
    }

    /**
     * @param string $share
     * @return boolean $isShareValid
     */
    static public function isShareValid($share)
    {
        return array_key_exists($share, static::$shareChoices);
    }

    /**
     * @return string $apiKey
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @return array $providers
     */
    public function getProviders()
    {
        return $this->providers;
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

    public function login($provider)
    {
        $response = new Response();

        $this->client->send($this->factory->getLoginMessage($provider), $response);

        return $response;
    }
}
