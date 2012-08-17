<?php

namespace OpenSky\Bundle\GigyaBundle\Socializer;

use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Buzz\Client\ClientInterface;
use Buzz\Message\Response;
use OpenSky\Bundle\GigyaBundle\Security\User\User;
use OpenSky\Bundle\GigyaBundle\Socializer\Buzz\MessageFactory;
use OpenSky\Bundle\GigyaBundle\Socializer\UserAction;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class Socializer implements SocializerInterface, UserProviderInterface
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
        $this->apiKey    = (string) $apiKey;
        $this->providers = $providers;
        $this->client    = $client;
        $this->factory   = $factory;
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
     * @param string $redirect
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
    public function getAccessToken($code = null, $params = array())
    {
        $response = $this->factory->getResponse();
        $request  = $this->factory->getAccessTokenRequest($code, $params);

        $this->client->send($request, $response);

        $result = json_decode($response->getContent(), true);

        if (isset($result['error'])) {
            return null;
        }

        return $result;
    }

    public function getUserInfo($token, $uid = null)
    {
        $response = $this->factory->getResponse();
        $request  = $this->factory->getUserInfoRequest($token, $uid);

        $this->client->send($request, $response);

        libxml_use_internal_errors(true);

        $result = simplexml_load_string($response->getContent());

        if (!$result) {
            throw new \Exception('Gigya API returned invalid response');
        }

        if ((string) $result->errorCode) {
            throw new AuthenticationException((string) $result->errorMessage, (string) $result->errorDetails, (string) $result->errorCode);
        }

        return $result;
    }

    public function getUser($token, $uid = null)
    {
        $result = $this->getUserInfo($token, $uid);

        $user = new User((string) $result->UID, strtolower((string) $result->loginProvider));

        if (isset($result->identities)) {
            foreach ($result->identities->children() as $identity) {
                if ((string) $identity->provider === $user->getProvider()) {
                    $properties = array(
                        'nickname', 'firstName', 'lastName', 'gender', 'age',
                        'email', 'city', 'state', 'zip', 'country'
                    );

                    foreach ($properties as $property) {
                        if (isset($identity->{$property})) {
                            $user->{'set'.ucfirst($property)}((string) $identity->{$property});
                        }
                    }

                    $urls = array(
                        'thumbnailURL' => 'thumbnailUrl',
                        'profileURL'   => 'profileUrl',
                        'photoURL'     => 'photoUrl',
                    );

                    foreach ($urls as $property => $setter) {
                        if (isset($identity->{$property})) {
                            $user->{'set'.ucfirst($setter)}((string) $identity->{$property});
                        }
                    }

                    if (isset($identity->{'birthMonth'}) &&
                        isset($identity->{'birthDay'}) &&
                        isset($identity->{'birthYear'})) {
                        $user->setBirthday(\DateTime::createFromFormat('n-j-Y H:i', sprintf('%s-%s-%s 00:00', (string) $identity->{'birthMonth'}, (string) $identity->{'birthDay'}, (string) $identity->{'birthYear'})));
                    }
                }
            }
        }

        return $user;
    }

    public function setUserId($token, $uid, $id)
    {
        $response = $this->factory->getResponse();
        $request  = $this->factory->getSetUIDRequest($token, $uid, $id);

        $this->client->send($request, $response);

        libxml_use_internal_errors(true);

        $result = simplexml_load_string($response->getContent());

        if (!$result) {
            throw new \Exception('Gigya API returned invalid response');
        }

        if ((string) $result->errorCode) {
            throw new \Exception($result->errorMessage);
        }

        return true;
    }

    public function removeConnection($token, $uid, $provider = null)
    {
        $response = $this->factory->getResponse();
        $request  = $this->factory->getRemoveConnectionRequest($token, $uid, $provider);

        $this->client->send($request, $response);

        libxml_use_internal_errors(true);

        $result = simplexml_load_string($response->getContent());

        if (!$result) {
            throw new \Exception('Gigya API returned invalid response');
        }

        if ((string) $result->errorCode) {
            throw new \Exception($result->errorMessage);
        }

        return true;
    }

    public function notifyRegistration($token, $uid, $id, $message = null)
    {
        $response = $this->factory->getResponse();
        $request  = $this->factory->getNotifyRegistrationRequest($token, $uid, $id, $message);

        $this->client->send($request, $response);

        libxml_use_internal_errors(true);

        $result = simplexml_load_string($response->getContent());

        if (!$result) {
            throw new \Exception('Gigya API returned invalid response');
        }

        if ((string) $result->errorCode) {
            throw new \Exception($result->errorMessage);
        }

        return true;
    }

    public function notifyLogin($token, $id, $newUser = false, $message = null, $userInfo = null)
    {
        $response = $this->factory->getResponse();
        $request  = $this->factory->getNotifyLoginRequest($token, $id, $newUser, $message, $userInfo);

        $this->client->send($request, $response);

        libxml_use_internal_errors(true);

        $result = simplexml_load_string($response->getContent());

        if (!$result) {
            throw new \Exception('Gigya API returned invalid response');
        }

        if ((string) $result->errorCode) {
            throw new \Exception($result->errorMessage);
        }

        return $result;
    }

    public function getSessionInfo($uid, $provider)
    {
        $response = $this->factory->getResponse();
        $request  = $this->factory->getSessionInfoRequest($uid, $provider);

        $this->client->send($request, $response);

        libxml_use_internal_errors(true);

        $result = simplexml_load_string($response->getContent());

        if (!$result) {
            throw new \Exception('Gigya API returned invalid response');
        }

        if ((string) $result->errorCode) {
            throw new \Exception($result->errorMessage);
        }

        return $result;
    }

    /**
     * Removes the user account at gigya's
     *
     * @param   string  $token
     * @param   string  $id
     * @param   string  $message
     *
     * @return  \SimpleXMLElement   The response
     * @throws  \Exception  If invalid response or error
     */
    public function deleteAccount($token, $id, $message = null)
    {
        $response = $this->factory->getResponse();
        $request  = $this->factory->getDeleteAccountRequest($token, $id, $message);

        $this->client->send($request, $response);

        libxml_use_internal_errors(true);

        $result = simplexml_load_string($response->getContent());

        if (!$result) {
            throw new \Exception('Gigya API returned invalid response');
        }

        if ((string) $result->errorCode) {
            throw new \Exception($result->errorMessage);
        }

        return $result;
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException('Cannot load non-gigya users');
        }

        return $user;
    }

    public function loadUserByUsername($username)
    {
        throw new UsernameNotFoundException('Not implemented');
    }

    public function supportsClass($class)
    {
        return $class === 'OpenSky\Bundle\GigyaBundle\Security\User\User';
    }

    public function getGMchallengeStatus($token, $id, $details = null, $include = null, $exclude = null)
    {
        $response = $this->factory->getResponse();
        $request  = $this->factory->getGMchallengeStatusRequest($token, $id, $details, $include, $exclude);

        $this->client->send($request, $response);

        libxml_use_internal_errors(true);

        $result = json_decode($response->getContent());

        if (!$result) {
            throw new \Exception('Gigya API returned invalid response');
        }

        if ((string) $result->errorCode) {
            throw new \Exception($result->errorMessage);
        }

        return $result;
    }

    public function notifyAction($token, $uid, $action)
    {
        $response = $this->factory->getResponse();
        $request  = $this->factory->getNotifyActionRequest($token, $uid, $action);

        $this->client->send($request, $response);

        libxml_use_internal_errors(true);

        $result = json_decode($response->getContent());

        if (!$result) {
            throw new \Exception('Gigya API returned invalid response');
        }

        if ((string) $result->errorCode) {
            throw new \Exception($result->errorMessage);
        }

        return $result;
    }
    
    /**
     * Returns information about user's friends, but only which are also site users
     */
    public function getFriendsInfo($uid, $params = array())
    {
        $response = $this->factory->getResponse();
        $request  = $this->factory->getFriendsInfoRequest($uid, $this->getNonce(), $params);

        $this->client->send($request, $response);

        libxml_use_internal_errors(true);

        $result = simplexml_load_string($response->getContent());

        if (!$result) {
            throw new \Exception('Gigya API returned invalid response');
        }
        if ((string) $result->errorCode) {
            throw new AuthenticationException((string) $result->errorMessage, (string) $result->errorDetails, (string) $result->errorCode);
        }
        return $result;
    }
}
