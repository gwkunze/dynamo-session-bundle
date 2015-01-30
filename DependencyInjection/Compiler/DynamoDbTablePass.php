<?php
/**
 * Copyright (c) 2013 Gijs Kunze
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GWK\DynamoSessionBundle\DependencyInjection\Compiler;

use Aws\Common\Exception\InstanceProfileCredentialsException;
use Aws\Common\Exception\InvalidArgumentException;
use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Exception\ResourceNotFoundException;
use GWK\DynamoSessionBundle\Handler\SessionHandler;
use Guzzle\Service\Resource\Model;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Exception\LogicException;

class DynamoDbTablePass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if(!$container->findDefinition("dynamo_session_client")) {
            return;
        }

        if($container->getAlias('session.handler') != "dynamo_session_handler") {
            return;
        }

        /** @var $client DynamoDbClient */
        $client = $container->get("dynamo_session_client");

        $tableName = $container->getParameter("dynamo_session_table");

        try {
            /** @var $table Model */
            $client->describeTable(array('TableName' => $tableName));
        } catch(InstanceProfileCredentialsException $e) {
            throw new LogicException("Invalid DynamoDB security credentials or insufficient permissions", $e->getCode(), $e);
        } catch(ResourceNotFoundException $e) {
            /** @var $handler SessionHandler */
            $handler = $container->get("dynamo_session_handler");

            $read_capacity = $container->getParameter("dynamo_session_read_capacity");
            $write_capacity = $container->getParameter("dynamo_session_write_capacity");

            $handler->getHandler()->createSessionsTable($read_capacity, $write_capacity);
        }
    }
}
