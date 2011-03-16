<?php

namespace OpenSky\Bundle\GigyaBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class GigyaExtension extends Extension
{
    /**
     * @see Symfony\Component\DependencyInjection\Extension.ExtensionInterface::load()
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $modules = array(
            'socializer' => array(),
        );

        foreach ($configs as $config) {
            foreach (array_keys($modules) as $module) {
                if (array_key_exists($module, $config)) {
                    $modules[$module][] = isset($config[$module]) ? $config[$module] : array();
                }
            }
        }

        foreach (array_keys($modules) as $module) {
            if (!empty($modules[$module])) {
                call_user_func(array($this, $module . 'Load'), $modules[$module], $container);
            }
        }
    }

    /**
     * @param array            $configs
     * @param ContainerBuilder $container
     */
    private function socializerLoad(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('socializer.xml');

        foreach ($configs as $config) {
            foreach (array('api_key', 'namespace', 'providers', 'secret', 'redirect_route') as $key) {
                if (isset($config[$key])) {
                    $container->setParameter('gigya.socializer.'.$key, $config[$key]);
                }
            }
        }
    }

    /**
     * @see Symfony\Component\DependencyInjection\Extension.ExtensionInterface::getAlias()
     * @codeCoverageIgnore
     */
    public function getAlias()
    {
        return 'gigya';
    }
}
