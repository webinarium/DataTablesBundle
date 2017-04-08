<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2017 Artem Rodygin
//
//  This file is part of DataTables Symfony bundle.
//
//  You should have received a copy of the MIT License along with
//  the bundle. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace DataTables\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;

class DataTablesExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testLoadServices()
    {
        $container = new ContainerBuilder();

        self::assertFalse($container->has('datatables'));

        $extension = new DataTablesExtension();
        $extension->load([], $container);
        $extension->process($container);

        self::assertTrue($container->has('datatables'));
    }
}
