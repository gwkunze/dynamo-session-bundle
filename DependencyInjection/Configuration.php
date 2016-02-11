<?php
/**
 * Copyright (c) 2013 Gijs Kunze
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GWK\DynamoSessionBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('gwk_dynamo_session');

        $rootNode->canBeUnset()->children()
            ->scalarNode('table')->end()
            ->scalarNode('locking_strategy')->defaultValue("pessimistic")->end()
            ->scalarNode('dynamo_client_id')->end()
            ->booleanNode('automatic_gc')->end()
            ->scalarNode('gc_batch_size')->end()
            ->scalarNode('session_lifetime')->end()
            ->scalarNode('read_capacity')->defaultValue(10)->end()
            ->scalarNode('write_capacity')->defaultValue(10)->end()
            ->arrayNode('aws')
                ->info("AWS configuration")
                ->children()
                    ->scalarNode('region')->end()
                    ->scalarNode('version')->end()
                    ->scalarNode('key')->end()
                    ->scalarNode('secret')->end()
                ->end()
            ->end()
        ;


        return $treeBuilder;
    }
}
