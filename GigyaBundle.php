<?php

namespace OpenSky\Bundle\GigyaBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle as BaseBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use OpenSky\Bundle\GigyaBundle\DependencyInjection\Security\Factory\GigyaFactory;

class GigyaBundle extends BaseBundle {

    /**
     * {@inheritdoc}
     */
    public function getNamespace() {
	return __NAMESPACE__;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath() {
	return strtr(__DIR__, '\\', '/');
    }

    public function build(ContainerBuilder $container) {
	parent::build($container);

	$extension = $container->getExtension('security');
	$extension->addSecurityListenerFactory(new GigyaFactory());
    }

}
