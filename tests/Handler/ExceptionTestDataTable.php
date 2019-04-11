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

namespace DataTables\Handler;

use DataTables\DataTableException;
use DataTables\DataTableHandlerInterface;
use DataTables\DataTableQuery;
use DataTables\DataTableResults;

class ExceptionTestDataTable implements DataTableHandlerInterface
{
    public function handle(DataTableQuery $request): DataTableResults
    {
        throw new DataTableException('Something gone wrong.');
    }
}
