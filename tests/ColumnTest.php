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

class ColumnTest extends TestCase
{
    public function testConstructor()
    {
        $data       = bin2hex(random_bytes(10));
        $name       = bin2hex(random_bytes(10));
        $searchable = true;
        $orderable  = true;
        $value      = bin2hex(random_bytes(10));
        $regex      = true;

        $object = new Column($data, $name, $searchable, $orderable, new Search($value, $regex));

        self::assertEquals($data, $object->data);
        self::assertEquals($name, $object->name);
        self::assertEquals($searchable, $object->searchable);
        self::assertEquals($orderable, $object->orderable);
        self::assertEquals($value, $object->search->value);
        self::assertEquals($regex, $object->search->regex);
    }

    public function testJsonSerializable()
    {
        $data       = bin2hex(random_bytes(10));
        $name       = bin2hex(random_bytes(10));
        $searchable = true;
        $orderable  = true;
        $value      = bin2hex(random_bytes(10));
        $regex      = true;

        $expected = json_encode([
            'data'       => $data,
            'name'       => $name,
            'searchable' => $searchable,
            'orderable'  => $orderable,
            'search'     => [
                'value' => $value,
                'regex' => $regex,
            ],
        ]);

        $object = new Column($data, $name, $searchable, $orderable, new Search($value, $regex));

        self::assertEquals($expected, json_encode($object));
    }
}
