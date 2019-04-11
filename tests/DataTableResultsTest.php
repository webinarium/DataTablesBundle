<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2019 Artem Rodygin
//
//  This file is part of DataTables Symfony bundle.
//
//  You should have received a copy of the MIT License along with
//  the bundle. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace DataTables;

use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \DataTables\DataTableResults
 */
class DataTableResultsTest extends TestCase
{
    /**
     * @covers ::jsonSerialize
     */
    public function testJsonSerializable()
    {
        $expected = json_encode([
            'draw'            => 0,
            'recordsTotal'    => 100,
            'recordsFiltered' => 78,
            'data'            => [],
        ]);

        $object = new DataTableResults();

        $object->recordsTotal    = 100;
        $object->recordsFiltered = 78;
        $object->data            = [];

        self::assertSame($expected, json_encode($object));
    }
}
