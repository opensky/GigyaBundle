<?php

namespace OpenSky\Bundle\GigyaBundle\Tests\Security\EntryPoint;

use OpenSky\Bundle\GigyaBundle\Security\EntryPoint\GigyaAuthenticationEntryPoint;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;

class GigyaAuthenticationEntryPointTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldRenderProviderSelectionOnStart()
    {
        $event      = new Event($this, 'some.event');
        $request    = new Request();
        $socializer = $this->getMock('OpenSky\Bundle\GigyaBundle\Socializer\SocializerInterface');
        $engine     = $this->getMock('Symfony\Component\Templating\EngineInterface');
        $entry      = new GigyaAuthenticationEntryPoint($socializer, $engine);

        $engine->expects($this->once())
            ->method('render')
            ->with('GigyaBundle:Example:login_popup.html.twig', array());

        $entry->start($event, $request);
    }
}
