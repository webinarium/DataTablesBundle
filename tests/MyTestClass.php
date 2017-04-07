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
 * @property mixed $property
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
