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
 * Ordering parameters as part of DataTables request.
 *
 * @see http://www.datatables.net/manual/server-side
 *
 * @property-read   int    $column Column to which ordering should be applied.
 * @property-read   string $dir    Ordering direction for this column.
 */
class Order extends ValueObject
{
    const ASC  = 'asc';
    const DESC = 'desc';

    protected $column;
    protected $dir;

    /**
     * Initializing constructor.
     *
     * @param   int    $column
     * @param   string $dir
     */
    public function __construct($column, $dir)
    {
        $this->column = $column;
        $this->dir    = $dir;
    }
}
