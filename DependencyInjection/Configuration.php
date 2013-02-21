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
            ->scalarNode('read_capacity')->defaultValue(10)->end()
            ->scalarNode('write_capacity')->defaultValue(10)->end()
            ->arrayNode('aws')
                ->info("AWS configuration")
                ->children()
                    ->scalarNode('region')->end()
                    ->scalarNode('key')->end()
                    ->scalarNode('secret')->end()
                ->end()
            ->end()
        ;

//     * - locking_strategy:         Locking strategy for session locking logic
//     * - dynamodb_client:          Client for doing DynamoDB operations
//     * - table_name:               Name of the table in which to store sessions
//     * - hash_key:                 Name of the hash key in the sessions table
//     * - session_lifetime:         Lifetime of inactive sessions
//     * - consistent_read:          Use DynamoDB consistent reads for `GetItem`
//     * - automatic_gc:             Use PHP's auto garbage collection
//     * - gc_batch_size:            Batch size for garbage collection deletes
//     * - max_lock_wait_time:       Max time to wait for lock acquisition
//     * - min_lock_retry_microtime: Min time to wait between lock attempts
//     * - max_lock_retry_microtime: Max time to wait between lock attempts

        return $treeBuilder;
    }
}
