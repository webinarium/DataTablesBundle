<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2015-2022 Artem Rodygin
//
//  This file is part of DataTables Symfony bundle.
//
//  You should have received a copy of the MIT License along with
//  the bundle. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace DataTables\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @coversDefaultClass \DataTables\DependencyInjection\DataTablesExtension
 *
 * @internal
 */
final class DataTablesExtensionTest extends TestCase
{
    /**
     * @covers ::load
     * @covers ::process
     */
    public function testLoadServices(): void
    {
        $container = new ContainerBuilder();

        self::assertFalse($container->has('datatables'));

        $extension = new DataTablesExtension();
        $extension->load([], $container);
        $extension->process($container);

        self::assertTrue($container->has('datatables'));
    }
}
