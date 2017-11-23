<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2016 Artem Rodygin
//
//  This file is part of DataTables Symfony bundle.
//
//  You should have received a copy of the MIT License along with
//  the bundle. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace DataTables;

use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    public function testConstructor()
    {
        $column = random_int(1, 10);
        $dir    = Order::DESC;

        $object = new Order($column, $dir);

        self::assertEquals($column, $object->column);
        self::assertEquals($dir, $object->dir);
    }

    public function testJsonSerializable()
    {
        $column = random_int(1, 10);
        $dir    = Order::DESC;

        $expected = json_encode([
            'column' => $column,
            'dir'    => $dir,
        ]);

        $object = new Order($column, $dir);

        self::assertEquals($expected, json_encode($object));
    }
}
