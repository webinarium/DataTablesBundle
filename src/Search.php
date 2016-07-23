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
 * Search parameters as part of DataTables request.
 *
 * @see https://www.datatables.net/manual/server-side
 *
 * @property-read   string $value Search value.
 * @property-read   bool   $regex Whether the search value should be treated as a regular expression for advanced searching.
 */
class Search extends ValueObject
{
    protected $value;
    protected $regex;

    /**
     * Initializing constructor.
     *
     * @param   string $value
     * @param   bool   $regex
     */
    public function __construct(string $value = null, bool $regex = false)
    {
        $this->value = $value;
        $this->regex = $regex;
    }
}
