<?php

namespace Yan\Bundle\DeviceDetectorBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * Bundle Extension
 *
 * @author  Yan Barreta
 * @version dated: Dec 17, 2014 1:22:46 AM
 */
class DeviceDetectorExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $container->setParameter('device_detector', $config);

        $container->setParameter('device_detector.override_cookie', $config['override_cookie']);

        if (isset($config['mobile'])) {
            $container->setParameter('device_detector.mobile', $config['mobile']);
            $container->setParameter('device_detector.mobile.enabled', $config['mobile']['enabled']);
            $container->setParameter('device_detector.mobile.controllers', $config['mobile']['controllers']);
        }

        if (isset($config['tablet'])) {
            $container->setParameter('device_detector.tablet.enabled', $config['tablet']['enabled']);
            $container->setParameter('device_detector.tablet', $config['tablet']);
            $container->setParameter('device_detector.tablet.treat_as_mobile', $config['tablet']['treat_as_mobile']);
            $container->setParameter('device_detector.tablet.controllers', $config['tablet']['controllers']);
        }

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
