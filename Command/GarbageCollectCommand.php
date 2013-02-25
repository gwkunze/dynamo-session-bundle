<?php
/**
 * Copyright (c) 2013 Gijs Kunze
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GWK\DynamoSessionBundle\Command;

use GWK\DynamoSessionBundle\Handler\SessionHandler;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Console Command to perform a manual garbage collection
 */
class GarbageCollectCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName("session:garbage-collect")
            ->setDescription("Clear expired sessions from DynamoDB");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();

        if(!$container->has("dynamo_session_handler")) {
            // No dynamo session handling configured, so do nothing
            return 0;
        }

        /** @var $client SessionHandler */
        $client = $container->get("dynamo_session_handler");

        $client->getHandler()->garbageCollect();

        return 0;
    }
}