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

use Symfony\Component\HttpFoundation\Request;

/**
 * DataTables lookup service.
 */
interface DataTablesInterface
{
    /**
     * Handles specified DataTable request.
     *
     * @param Request $request Original request.
     * @param string  $id      DataTable ID.
     *
     * @throws DataTableException
     *
     * @return DataTableResults Object with data to return in JSON response.
     */
    public function handle(Request $request, string $id): DataTableResults;
}
