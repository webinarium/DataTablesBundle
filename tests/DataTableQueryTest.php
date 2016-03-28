<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2016 Artem Rodygin
//
//  This file is part of DataTables Symfony bundle.
//
//  You should have received a copy of the MIT License along with
//  the bundle. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace DataTables;

use Symfony\Component\HttpFoundation\Request;

class DataTableQueryTest extends \PHPUnit_Framework_TestCase
{
    public function testSuccess()
    {
        $request = new Request([
            'draw'    => mt_rand(),
            'start'   => 20,
            'length'  => 10,
            'search'  => ['value' => null, 'regex' => false],
            'order'   => [
                ['column' => 1, 'dir' => 'desc'],
                ['column' => 0, 'dir' => 'asc'],
            ],
            'columns' => [
                ['data' => 0, 'name' => '#1', 'searchable' => true, 'orderable' => false, 'search' => ['value' => 'first', 'regex' => false]],
                ['data' => 1, 'name' => '#2', 'searchable' => false, 'orderable' => true, 'search' => ['value' => 'second', 'regex' => true]],
            ],
        ]);

        $params = new Parameters();

        $params->draw    = $request->get('draw');
        $params->start   = $request->get('start');
        $params->length  = $request->get('length');
        $params->search  = $request->get('search');
        $params->order   = $request->get('order');
        $params->columns = $request->get('columns');

        $query = new DataTableQuery($params);

        self::assertEquals(20, $query->start);
        self::assertEquals(10, $query->length);

        self::assertEquals('', $query->search->value);
        self::assertFalse($query->search->regex);

        self::assertCount(2, $query->order);
        self::assertEquals(1, $query->order[0]->column);
        self::assertEquals(0, $query->order[1]->column);
        self::assertEquals(Order::DESC, $query->order[0]->dir);
        self::assertEquals(Order::ASC, $query->order[1]->dir);

        self::assertCount(2, $query->columns);
        self::assertEquals(0, $query->columns[0]->data);
        self::assertEquals(1, $query->columns[1]->data);
        self::assertEquals('#1', $query->columns[0]->name);
        self::assertEquals('#2', $query->columns[1]->name);
        self::assertTrue($query->columns[0]->searchable);
        self::assertFalse($query->columns[1]->searchable);
        self::assertFalse($query->columns[0]->orderable);
        self::assertTrue($query->columns[1]->orderable);
        self::assertEquals('first', $query->columns[0]->search->value);
        self::assertEquals('second', $query->columns[1]->search->value);
        self::assertFalse($query->columns[0]->search->regex);
        self::assertTrue($query->columns[1]->search->regex);
    }
}
