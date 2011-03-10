<?php

namespace OpenSky\Bundle\GigyaBundle\Tests\Functional\SocializerFeatureTest;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SocializerFeatureTest extends WebTestCase
{
    public function testLoginRequest()
    {
        $kernel = $this->createKernel();
        $kernel->boot();

        $response = $kernel->getContainer()->get('gigya.socializer')->login('twitter');

        $this->assertInstanceOf('Buzz\Message\Response', $response);
        $this->assertEquals(200, $response->getStatusCode());
    }
}
