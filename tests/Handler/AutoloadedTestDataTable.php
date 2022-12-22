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

use DataTables\AbstractDataTableHandler;
use DataTables\DataTableQuery;
use DataTables\DataTableResults;

class AutoloadedTestDataTable extends AbstractDataTableHandler
{
    public const ID = 'testAuto';

    public function handle(DataTableQuery $request, array $context = []): DataTableResults
    {
        $results = new DataTableResults();

        $results->recordsTotal    = 200;
        $results->recordsFiltered = 20;
        $results->data            = [];

        return $results;
    }
}
