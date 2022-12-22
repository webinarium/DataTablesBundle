<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2015-2019 Artem Rodygin
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
 * @property string $value Search value.
 * @property bool   $regex Whether the search value should be treated as a regular expression for advanced searching.
 */
class Search extends ValueObject implements \JsonSerializable
{
    protected $value;
    protected $regex;

    /**
     * Initializing constructor.
     *
     * @param null|string $value
     * @param bool        $regex
     */
    public function __construct(string $value = null, bool $regex = false)
    {
        $this->value = $value;
        $this->regex = $regex;
    }

    /**
     * {@inheritdoc}
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'value' => $this->value,
            'regex' => $this->regex,
        ];
    }
}
