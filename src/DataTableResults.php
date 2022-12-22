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

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Data to return to DataTables plugin.
 *
 * @see https://www.datatables.net/manual/server-side
 *
 * @property int   $recordsTotal    Total records, before filtering
 * @property int   $recordsFiltered Total records, after filtering
 * @property array $data            The data to be displayed in the table
 */
class DataTableResults implements \JsonSerializable
{
    public const DT_ROW_ID    = 'DT_RowId';
    public const DT_ROW_CLASS = 'DT_RowClass';
    public const DT_ROW_DATA  = 'DT_RowData';
    public const DT_ROW_ATTR  = 'DT_RowAttr';

    /**
     * @Assert\NotNull
     * @Assert\GreaterThanOrEqual(value="0")
     */
    public $recordsTotal = 0;

    /**
     * @Assert\NotNull
     * @Assert\GreaterThanOrEqual(value="0")
     */
    public $recordsFiltered = 0;

    /**
     * @Assert\NotNull
     * @Assert\Type(type="array")
     */
    public $data = [];

    /**
     * @Assert\NotNull
     * @Assert\GreaterThanOrEqual(value="0")
     */
    private $draw = 0;

    /**
     * Convert results into array as expected by DataTables plugin.
     */
    public function jsonSerialize(): array
    {
        return [
            'draw'            => (int) $this->draw,
            'recordsTotal'    => (int) $this->recordsTotal,
            'recordsFiltered' => (int) $this->recordsFiltered,
            'data'            => $this->data,
        ];
    }
}
