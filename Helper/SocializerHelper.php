<?php

namespace OpenSky\Bundle\GigyaBundle\Helper;

use OpenSky\Bundle\GigyaBundle\Socializer;
use Symfony\Component\Templating\Helper\Helper;

class SocializerHelper extends Helper
{
    private $socializer;

    public function __construct(Socializer $socializer)
    {
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
     * @return string $name
     */
    public function getNamespace()
    {
		return $this->socializer->getNamespace();
    }

    /**
     * @param string $key
     * @return string $shareFunctionName
     */
    public function getShareFunctionName($key)
    {
        return $this->socializer->getNamespace().".showShareUI_".$key;
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
