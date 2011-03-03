<?php

namespace AntiMattr\GigyaBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle as BaseBundle;

class GigyaBundle extends BaseBundle
{
    /**
     * {@inheritdoc}
     */
    public function getNamespace()
    {
        return __NAMESPACE__;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath()
    {
        return strtr(__DIR__, '\\', '/');
    }
}
