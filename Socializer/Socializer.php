<?php

namespace OpenSky\Bundle\GigyaBundle\Socializer;

use Buzz\Client\ClientInterface;
use Buzz\Message\Response;
use OpenSky\Bundle\GigyaBundle\Socializer\Buzz\MessageFactory;
use OpenSky\Bundle\GigyaBundle\Socializer\UserAction;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

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

    /**
     * @param string $provider
     *
     * @return Buzz\Message\Response
     */
    public function login($provider)
    {
        $response = $this->factory->getResponse();

        $this->client->send($this->factory->getLoginRequest($provider), $response);

        return $response;
    }

    /**
     * @return array|null
     */
    public function getAccessToken()
    {
        $response = $this->factory->getResponse();

        $this->client->send($this->factory->getAccessTokenRequest(), $response);

        $result = json_decode($response->getContent(), true);

        if (isset($result['error'])) {
            throw new AuthenticationException($result['error_description']);
        }

        return $result;
    }
}
