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

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

/**
 * @coversDefaultClass \DataTables\DataTableQuery
 */
class DataTableQueryTest extends TestCase
{
    /** @var Parameters */
    protected $parameters;

    protected function setUp()
    {
        parent::setUp();

        $request = new Request([
            'draw'    => mt_rand(),
            'start'   => '20',
            'length'  => '10',
            'search'  => ['value' => 'symfony', 'regex' => 'false'],
            'order'   => [
                ['column' => '1', 'dir' => 'desc'],
                ['column' => '0', 'dir' => 'asc'],
            ],
            'columns' => [
                ['data' => '0', 'name' => '#1', 'searchable' => 'true', 'orderable' => 'false', 'search' => ['value' => 'first', 'regex' => 'false']],
                ['data' => '1', 'name' => '#2', 'searchable' => 'false', 'orderable' => 'true', 'search' => ['value' => 'second', 'regex' => 'true']],
            ],
        ]);

        $this->parameters = new Parameters();

        $this->parameters->draw    = $request->get('draw');
        $this->parameters->start   = $request->get('start');
        $this->parameters->length  = $request->get('length');
        $this->parameters->search  = $request->get('search');
        $this->parameters->order   = $request->get('order');
        $this->parameters->columns = $request->get('columns');
    }

    /**
     * @covers ::__construct
     */
    public function testSuccess()
    {
        $query = new DataTableQuery($this->parameters);

        self::assertSame(20, $query->start);
        self::assertSame(10, $query->length);

        self::assertSame('symfony', $query->search->value);
        self::assertFalse($query->search->regex);

        self::assertCount(2, $query->order);
        self::assertSame(1, $query->order[0]->column);
        self::assertSame(0, $query->order[1]->column);
        self::assertSame(Order::DESC, $query->order[0]->dir);
        self::assertSame(Order::ASC, $query->order[1]->dir);

        self::assertCount(2, $query->columns);
        self::assertSame('0', $query->columns[0]->data);
        self::assertSame('1', $query->columns[1]->data);
        self::assertSame('#1', $query->columns[0]->name);
        self::assertSame('#2', $query->columns[1]->name);
        self::assertTrue($query->columns[0]->searchable);
        self::assertFalse($query->columns[1]->searchable);
        self::assertFalse($query->columns[0]->orderable);
        self::assertTrue($query->columns[1]->orderable);
        self::assertSame('first', $query->columns[0]->search->value);
        self::assertSame('second', $query->columns[1]->search->value);
        self::assertFalse($query->columns[0]->search->regex);
        self::assertTrue($query->columns[1]->search->regex);
    }

    /**
     * @covers ::jsonSerialize
     */
    public function testJsonSerializable()
    {
        $expected = json_encode([
            'start'   => 20,
            'length'  => 10,
            'search'  => ['value' => 'symfony', 'regex' => false],
            'order'   => [
                ['column' => 1, 'dir' => 'desc'],
                ['column' => 0, 'dir' => 'asc'],
            ],
            'columns' => [
                ['data' => '0', 'name' => '#1', 'searchable' => true, 'orderable' => false, 'search' => ['value' => 'first', 'regex' => false]],
                ['data' => '1', 'name' => '#2', 'searchable' => false, 'orderable' => true, 'search' => ['value' => 'second', 'regex' => true]],
            ],
        ]);

        $query = new DataTableQuery($this->parameters);

        self::assertSame($expected, json_encode($query));
    }
}
