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

/**
 * @property-read   mixed $property
 */
class MyTestClass extends ValueObject
{
    protected $property;

    public function setProperty($value)
    {
        $this->property = $value;
    }

    public function getProperty()
    {
        return $this->property;
    }
}

class ValueObjectTest extends \PHPUnit_Framework_TestCase
{
    public function testIsSet()
    {
        $object = new MyTestClass();

        $this->assertTrue(isset($object->property));
        $this->assertFalse(isset($object->unknown));
    }

    public function testGetPropertySuccess()
    {
        $object   = new MyTestClass();
        $expected = mt_rand();

        $object->setProperty($expected);

        $this->assertEquals($expected, $object->property);
    }

    /**
     * @expectedException \Exception
     */
    public function testGetPropertyFailure()
    {
        $object = new MyTestClass();

        /** @noinspection PhpUndefinedFieldInspection */
        echo $object->unknown;
    }
}
