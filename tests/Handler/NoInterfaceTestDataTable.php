<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2015 Artem Rodygin
//
//  This file is part of DataTables Symfony bundle.
//
//  You should have received a copy of the MIT License along with
//  the bundle. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace DataTables\Handler;

use DataTables\DataTableResults;

class NoInterfaceTestDataTable
{
    public function handle()
    {
        $results = new DataTableResults();

        $results->recordsTotal    = 100;
        $results->recordsFiltered = 10;
        $results->data            = [];

        return $results;
    }
}
