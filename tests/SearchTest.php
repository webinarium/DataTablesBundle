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

class SearchTest extends TestCase
{
    public function testConstructor()
    {
        $value = bin2hex(random_bytes(10));
        $regex = true;

        $object = new Search($value, $regex);

        self::assertSame($value, $object->value);
        self::assertSame($regex, $object->regex);
    }

    public function testJsonSerializable()
    {
        $value = bin2hex(random_bytes(10));
        $regex = true;

        $expected = json_encode([
            'value' => $value,
            'regex' => $regex,
        ]);

        $object = new Search($value, $regex);

        self::assertSame($expected, json_encode($object));
    }
}
