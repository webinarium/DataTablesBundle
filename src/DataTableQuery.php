<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2015-2016 Artem Rodygin
//
//  This file is part of DataTables Symfony bundle.
//
//  You should have received a copy of the MIT License along with
//  the bundle. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace DataTables;

/**
 * A draw query from DataTables plugin.
 *
 * @see http://www.datatables.net/manual/server-side
 *
 * @property-read   int      $start   Index of first row to return, zero-based.
 * @property-read   int      $length  Total number of rows to return (-1 to return all rows).
 * @property-read   Search   $search  Global search value.
 * @property-read   Order[]  $order   Columns ordering (zero-based column index and direction).
 * @property-read   Column[] $columns Columns information (searchable, orderable, search value, etc).
 */
class DataTableQuery extends ValueObject
{
    protected $start;
    protected $length;
    protected $search;
    protected $order;
    protected $columns;

    /**
     * Initializing constructor.
     *
     * @param   Parameters $params
     */
    public function __construct(Parameters $params)
    {
        $this->start   = (int) $params->start;
        $this->length  = (int) $params->length;
        $this->search  = new Search($params->search['value'], (bool) $params->search['regex']);
        $this->order   = [];
        $this->columns = [];

        foreach ($params->order as $order) {
            $this->order[] = new Order((int) $order['column'], $order['dir']);
        }

        foreach ($params->columns as $column) {
            $this->columns[] = new Column(
                $column['data'],
                $column['name'],
                (bool) $column['searchable'],
                (bool) $column['orderable'],
                new Search($column['search']['value'], (bool) $column['search']['regex'])
            );
        }
    }
}
