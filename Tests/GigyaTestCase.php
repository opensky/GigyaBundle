<?php

namespace OpenSky\Bundle\GigyaBundle\Tests;

use Buzz\Client\ClientInterface;
use OpenSky\Bundle\GigyaBundle\Socializer\Buzz\MessageFactory;
use OpenSky\Bundle\GigyaBundle\Socializer\Socializer;

abstract class GigyaTestCase extends \PHPUnit_Framework_TestCase
{
    protected $apiKey    = 'xxxxxx';
    protected $providers = array('twitter', 'facebook');

    /**
     * @param Buzz\Client\ClientInterface                               $client
     * @param OpenSky\Bundle\GigyaBundle\Socializer\Buzz\MessageFactory $factory
     *
     * @return OpenSky\Bundle\GigyaBundle\Socializer\Socializer
     */
    protected function getSocializer(ClientInterface $client, MessageFactory $factory)
    {
        return new Socializer($this->apiKey, $this->providers, $client, $factory);
    }

    /**
     * @return OpenSky\Bundle\GigyaBundle\Socializer\Buzz\MessageFactory
     */
    protected function getMockMessageFactory()
    {
        return $this->getMockBuilder('OpenSky\Bundle\GigyaBundle\Socializer\Buzz\MessageFactory')
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @return Buzz\Client\ClientInterface
     */
    protected function getMockClient()
    {
        return $this->getMock('Buzz\Client\ClientInterface');
    }
}
