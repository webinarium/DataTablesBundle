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
     * @param Request $request Original request
     * @param string  $id      DataTable ID
     * @param array   $context Optional context of the request
     *
     * @return DataTableResults Object with data to return in JSON response
     *
     * @throws DataTableException
     */
    public function handle(Request $request, string $id, array $context): DataTableResults;
}
