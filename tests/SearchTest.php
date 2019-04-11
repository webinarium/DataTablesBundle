<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2015-2019 Artem Rodygin
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
 * @coversDefaultClass \DataTables\Search
 */
class SearchTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testConstructor()
    {
        $value = bin2hex(random_bytes(10));
        $regex = true;

        $object = new Search($value, $regex);

        self::assertSame($value, $object->value);
        self::assertSame($regex, $object->regex);
    }

    /**
     * @covers ::jsonSerialize
     */
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
