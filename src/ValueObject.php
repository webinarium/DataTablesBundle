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

/**
 * Immutable value object.
 */
class ValueObject
{
    /**
     * Checks whether specified property exists.
     *
     * @param   string $name Name of the property.
     *
     * @return  bool TRUE if the property exists, FALSE otherwise.
     */
    public function __isset($name)
    {
        return property_exists($this, $name);
    }

    /**
     * Returns current value of specified property.
     *
     * @param   string $name Name of the property.
     *
     * @throws  \BadMethodCallException If the property doesn't exist.
     *
     * @return  mixed Current value of the property.
     */
    public function __get($name)
    {
        if (!property_exists($this, $name)) {
            throw new \BadMethodCallException(sprintf('Unknown property "%s" in class "%s".', $name, get_class($this)));
        }

        return $this->$name;
    }
}
