<?php
/**
 * Copyright (c) 2013 Gijs Kunze
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GWK\DynamoSessionBundle;

use GWK\DynamoSessionBundle\DependencyInjection\Compiler\DynamoDbTablePass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class GWKDynamoSessionBundle extends Bundle
{
    public function build(ContainerBuilder $container) {
        parent::build($container);

        $container->addCompilerPass(new DynamoDbTablePass());
    }
}
