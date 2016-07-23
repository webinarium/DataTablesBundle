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
 * Column parameters as part of DataTables request.
 *
 * @see https://www.datatables.net/manual/server-side
 *
 * @property-read   string $data       Column's data source.
 * @property-read   string $name       Column's name.
 * @property-read   bool   $searchable Flag to indicate if this column is searchable or not.
 * @property-read   bool   $orderable  Flag to indicate if this column is orderable or not.
 * @property-read   Search $search     Search value to apply to this specific column.
 */
class Column extends ValueObject
{
    protected $data;
    protected $name;
    protected $searchable;
    protected $orderable;
    protected $search;

    /**
     * Initializing constructor.
     *
     * @param   string $data
     * @param   string $name
     * @param   bool   $searchable
     * @param   bool   $orderable
     * @param   Search $search
     */
    public function __construct(string $data, string $name, bool $searchable, bool $orderable, Search $search)
    {
        $this->data       = $data;
        $this->name       = $name;
        $this->searchable = $searchable;
        $this->orderable  = $orderable;
        $this->search     = $search;
    }
}
