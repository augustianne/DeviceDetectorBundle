<?php

/*
 * This file is part of DeviceDetectorBundle.
 *
 * Yan Barreta <augustianne.barreta@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Yan\Bundle\DeviceDetectorBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Bundle configuration
 *
 * @author  Yan Barreta
 * @version dated: Dec 17, 2014 1:22:46 AM
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('device_detector');

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('override_cookie')->defaultValue('DEVICE_DETECTOR_OVERRIDE')->end()
                ->arrayNode('mobile')
                    ->canBeEnabled()
                    ->children()
                        ->booleanNode('enabled')->defaultFalse()->end()
                        ->arrayNode('controllers')
                            ->isRequired()
                            ->prototype('array')
                                ->children()
                                    ->scalarNode('from_controller_path')
                                        ->isRequired()
                                        ->end()
                                    ->scalarNode('to_controller_path')
                                        ->isRequired()
                                    ->end()
                                    ->arrayNode('routes')
                                        ->defaultValue(array())
                                        ->beforeNormalization()->ifString()->then(function ($v) { return array($v); })->end()
                                        ->prototype('scalar')->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('tablet')
                    ->canBeEnabled()
                    ->children()
                        ->booleanNode('enabled')->defaultFalse()->end()
                        ->booleanNode('treat_as_mobile')->defaultTrue()->end()
                        ->arrayNode('controllers')
                            ->isRequired()
                            ->prototype('array')
                                ->children()
                                    ->scalarNode('from_controller_path')
                                        ->isRequired()
                                        ->end()
                                    ->scalarNode('to_controller_path')
                                        ->isRequired()
                                    ->end()
                                    ->arrayNode('routes')
                                        ->defaultValue(array())
                                        ->beforeNormalization()->ifString()->then(function ($v) { return array($v); })->end()
                                        ->prototype('scalar')->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
