<?php

namespace OpenSky\Bundle\GigyaBundle\Helper;

use OpenSky\Bundle\GigyaBundle\Socializer\Socializer;
use Symfony\Component\Templating\Helper\Helper;

class SocializerHelper extends Helper
{
    private $socializer;
    private $namespace;

    public function __construct(Socializer $socializer, $namespace)
    {
        $this->namespace  = $namespace;
        $this->socializer = $socializer;
    }

    /**
     * @return string $apiKey
     */
    public function getApiKey()
    {
        return $this->socializer->getApiKey();
    }

    /**
     * @return string $namespace
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @return string $loginFunctionName
     */
    public function getLoginFunctionName()
    {
        return $this->namespace.".login";
    }

    /**
     * @return string $loginUIFunctionName
     */
    public function getLoginUIFunctionName()
    {
        return $this->namespace.".showLoginUI";
    }

    /**
     * @return array $providers
     */
    public function getProviders()
    {
        return $this->socializer->getProviders();
    }

    /**
     * @param string $key
     * @return string $shareFunctionName
     */
    public function getShareFunctionName($key)
    {
        return $this->namespace.".showShareUI_".$key;
    }

    /**
     * @param string $key
     * @return string $shareBarFunctionName
     */
    public function getShareBarFunctionName($key)
    {
        return $this->namespace.".showShareBarUI_".$key;
    }

    /**
     * @param string $key
     * @return AntiMattr\GigyaBundle\Socializer\UserAction $userAction
     */
    public function getUserActionByKey($key)
    {
        if ($this->socializer->hasUserActionByKey($key)) {
            return $this->socializer->getUserActionByKey($key);
        }
    }

    public function getName()
    {
        return 'gigya_socializer';
    }
}
