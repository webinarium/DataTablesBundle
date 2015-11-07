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

namespace DataTables;

use Psr\Log\NullLogger;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validation;

class SuccessfulTestDataTable implements DataTableHandlerInterface
{
    public function handle(DataTableQuery $request)
    {
        $results = new DataTableResults();

        $results->recordsTotal    = 100;
        $results->recordsFiltered = 10;
        $results->data            = [];

        return $results;
    }
}

class ExceptionTestDataTable implements DataTableHandlerInterface
{
    public function handle(DataTableQuery $request)
    {
        throw new DataTableException('Something gone wrong.');
    }
}

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

class InvalidResultsTestDataTable implements DataTableHandlerInterface
{
    public function handle(DataTableQuery $request)
    {
        $results = new DataTableResults();

        $results->recordsTotal    = 100;
        $results->recordsFiltered = 10;
        $results->data            = null;

        return $results;
    }
}

class DataTablesFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var \DataTables\DataTablesInterface */
    protected $datatables;

    protected function setUp()
    {
        $container = new Container();
        $logger    = new NullLogger();

        $validator = Validation::createValidatorBuilder()
            ->enableAnnotationMapping()
            ->getValidator();

        $container->set('datatable.test.success',   new SuccessfulTestDataTable());
        $container->set('datatable.test.exception', new ExceptionTestDataTable());
        $container->set('datatable.test.interface', new NoInterfaceTestDataTable());
        $container->set('datatable.test.invalid',   new InvalidResultsTestDataTable());

        $this->datatables = new DataTables($container, $logger, $validator);

        $this->datatables->addService('datatable.test.success',   'testSuccess');
        $this->datatables->addService('datatable.test.exception', 'testException');
        $this->datatables->addService('datatable.test.interface', 'testInterface');
        $this->datatables->addService('datatable.test.invalid',   'testInvalid');
    }

    public function testSuccess()
    {
        $draw = mt_rand();

        $request = new Request([
            'draw'    => $draw,
            'start'   => 0,
            'length'  => 10,
            'search'  => ['value' => null, 'regex' => 'false'],
            'order'   => [],
            'columns' => [],
        ]);

        $expected = [
            'draw'            => $draw,
            'recordsTotal'    => 100,
            'recordsFiltered' => 10,
            'data'            => [],
        ];

        $results = $this->datatables->handle($request, 'testSuccess');

        $this->assertEquals($expected, $results);
    }

    /**
     * @expectedException \DataTables\DataTableException
     * @expectedExceptionMessage Something gone wrong.
     */
    public function testException()
    {
        $request = new Request([
            'draw'    => mt_rand(),
            'start'   => 0,
            'length'  => 10,
            'search'  => ['value' => null, 'regex' => 'false'],
            'order'   => [],
            'columns' => [],
        ]);

        $this->datatables->handle($request, 'testException');
    }

    /**
     * @expectedException \DataTables\DataTableException
     * @expectedExceptionMessage This value should not be null.
     */
    public function testBadQuery()
    {
        $request = new Request([
            'start'   => 0,
            'length'  => 10,
            'search'  => ['value' => null, 'regex' => 'false'],
            'order'   => [],
            'columns' => [],
        ]);

        $this->datatables->handle($request, 'testSuccess');
    }

    /**
     * @expectedException \DataTables\DataTableException
     * @expectedExceptionMessage Unknown DataTable ID.
     */
    public function testUnknownService()
    {
        $request = new Request([
            'draw'    => mt_rand(),
            'start'   => 0,
            'length'  => 10,
            'search'  => ['value' => null, 'regex' => 'false'],
            'order'   => [],
            'columns' => [],
        ]);

        $this->datatables->handle($request, 'testUnknown');
    }

    /**
     * @expectedException \DataTables\DataTableException
     * @expectedExceptionMessage DataTable handler must implement "DataTableHandlerInterface" interface.
     */
    public function testNoInterface()
    {
        $request = new Request([
            'draw'    => mt_rand(),
            'start'   => 0,
            'length'  => 10,
            'search'  => ['value' => null, 'regex' => 'false'],
            'order'   => [],
            'columns' => [],
        ]);

        $this->datatables->handle($request, 'testInterface');
    }

    /**
     * @expectedException \DataTables\DataTableException
     * @expectedExceptionMessage This value should not be null.
     */
    public function testInvalidResults()
    {
        $request = new Request([
            'draw'    => mt_rand(),
            'start'   => 0,
            'length'  => 10,
            'search'  => ['value' => null, 'regex' => 'false'],
            'order'   => [],
            'columns' => [],
        ]);

        $this->datatables->handle($request, 'testInvalid');
    }
}
