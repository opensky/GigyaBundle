<?php

namespace AntiMattr\GigyaBundle\Extension;

use AntiMattr\GigyaBundle\Helper\SocializerHelper;

class SocializerExtension extends \Twig_Extension
{
    private $socializerHelper;

    public function __construct(SocializerHelper $socializerHelper)
    {
        $this->socializerHelper = $socializerHelper;
    }

    public function getGlobals()
    {
        return array(
            'gigya_socializer' => $this->socializerHelper
        );
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'gigya_socializer';
    }
}
