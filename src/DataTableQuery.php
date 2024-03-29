<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2015-2022 Artem Rodygin
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
 * @see https://www.datatables.net/manual/server-side
 *
 * @property int      $start      Index of first row to return, zero-based
 * @property int      $length     Total number of rows to return (-1 to return all rows)
 * @property Search   $search     Global search value
 * @property Order[]  $order      Columns ordering (zero-based column index and direction)
 * @property Column[] $columns    Columns information (searchable, orderable, search value, etc)
 * @property array    $customData Custom data from DataTables
 */
class DataTableQuery extends ValueObject implements \JsonSerializable
{
    protected $start;
    protected $length;
    protected $search;
    protected $order;
    protected $columns;
    protected $customData;

    /**
     * Initializing constructor.
     */
    public function __construct(Parameters $params)
    {
        $this->start  = (int) $params->start;
        $this->length = (int) $params->length;

        $this->search = new Search(
            $params->search['value'],
            'true' === $params->search['regex']
        );

        $this->order = array_map(function (array $order): Order {
            return new Order(
                (int) $order['column'],
                $order['dir']
            );
        }, $params->order);

        $this->columns = array_map(function (array $column): Column {
            return new Column(
                $column['data'],
                $column['name'],
                'true'  === $column['searchable'],
                'true'  === $column['orderable'],
                new Search($column['search']['value'], 'true' === $column['search']['regex'])
            );
        }, $params->columns);

        $this->customData = $params->customData;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize(): array
    {
        $callback = function (\JsonSerializable $item): array {
            return $item->jsonSerialize();
        };

        return [
            'start'   => $this->start,
            'length'  => $this->length,
            'search'  => $this->search->jsonSerialize(),
            'order'   => array_map($callback, $this->order),
            'columns' => array_map($callback, $this->columns),
        ];
    }
}
