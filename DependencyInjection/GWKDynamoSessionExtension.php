<?php
/**
 * Copyright (c) 2013 Gijs Kunze
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GWK\DynamoSessionBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class GWKDynamoSessionExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        if(!isset($config['table'])) {
            return;
        }

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $aws_config = array();
        if(isset($config['aws'])) {
            $aws_config = $config['aws'];
        }

        if(!isset($config['dynamo_client_id'])) {
            $dynamoClass = $container->getParameter("dynamo_session_client.class");

            $def = new Definition($dynamoClass);
            $def->setFactoryClass($dynamoClass);
            $def->setFactoryMethod("factory");
            $def->setArguments(array($aws_config));

            $container->setDefinition("dynamo_session_client", $def);
            $config['dynamo_client_id'] = "dynamo_session_client";
        } else {
            $container->removeDefinition("dynamo_session_client");
            $container->setAlias("dynamo_session_client", $config['dynamo_client_id']);
        }

        $container->setParameter("dynamo_session_table", $config['table']);
        $container->setParameter("dynamo_session_read_capacity", $config['read_capacity']);
        $container->setParameter("dynamo_session_write_capacity", $config['write_capacity']);

        $dynamo_config = array(
            'table_name' => $config['table'],
            'locking_strategy' => $config['locking_strategy'],
        );

        foreach(array('automatic_gc', 'gc_batch_size', 'session_lifetime') as $key) {
            if(isset($config[$key])) {
                $dynamo_config[$key] = $config[$key];
            }
        }

        $handler = $container->getDefinition("dynamo_session_handler");
        $handler->setArguments(array(
            new Reference("dynamo_session_client"),
            $dynamo_config,
        ));

    }
}
