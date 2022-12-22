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
 * DataTable handler.
 */
interface DataTableHandlerInterface
{
    /**
     * Optional DataTable ID.
     */
    public const ID = null;

    /**
     * Handles specified DataTable request.
     *
     * @param DataTableQuery $request Original request
     * @param array          $context Optional context of the request
     *
     * @return DataTableResults Object with data to return in JSON response
     *
     * @throws DataTableException
     */
    public function handle(DataTableQuery $request, array $context = []): DataTableResults;
}
