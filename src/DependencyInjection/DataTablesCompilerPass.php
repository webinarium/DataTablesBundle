<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2015 Artem Rodygin
//
//  This file is part of DataTables Symfony bundle.
//
//  You should have received a copy of the MIT License along with
//  the bundle. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace DataTables\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Compiler pass for DataTables lookup service.
 */
class DataTablesCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('datatables')) {
            return;
        }

        $definition = $container->findDefinition('datatables');

        $services = $container->findTaggedServiceIds('datatable');

        foreach ($services as $id => $tags) {

            if (isset($tags[0]['id'])) {

                $definition->addMethodCall('addService', [
                    $id,
                    $tags[0]['id'],
                ]);
            }
        }
    }
}
