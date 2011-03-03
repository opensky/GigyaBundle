<?php

namespace AntiMattr\GigyaBundle\Tests\Socializer;

use AntiMattr\GigyaBundle\Socializer\ActionLink;

class ActionLinkTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $destination = "bar";
        $title = "foo";

        $actionLink = new ActionLink($title, $destination);
        $this->assertEquals($destination, $actionLink->getDestination());
        $this->assertEquals($title, $actionLink->getTitle());	
    }
}
