<?php

namespace OpenSky\Bundle\GigyaBundle;

use OpenSky\Bundle\GigyaBundle\DependencyInjection\OpenSkyGigyaExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class OpenSkyGigyaBundle extends Bundle
{
    public function __construct()
    {
        $this->extension = new OpenSkyGigyaExtension();
    }
}
