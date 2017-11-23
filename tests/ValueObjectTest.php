<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2016 Artem Rodygin
//
//  You should have received a copy of the GNU General Public License
//  along with the file. If not, see <http://www.gnu.org/licenses/>.
//
//----------------------------------------------------------------------

namespace DataTables;

use PHPUnit\Framework\TestCase;

class ValueObjectTest extends TestCase
{
    public function testIsSet()
    {
        $object = new MyTestClass();

        self::assertTrue(isset($object->property));
        self::assertFalse(isset($object->unknown));
    }

    public function testGetPropertySuccess()
    {
        $object   = new MyTestClass();
        $expected = mt_rand();

        $object->setProperty($expected);

        self::assertEquals($expected, $object->property);
    }

    public function testGetPropertyFailure()
    {
        $this->expectException(\Exception::class);

        $object = new MyTestClass();

        /** @noinspection PhpUndefinedFieldInspection */
        echo $object->unknown;
    }
}
