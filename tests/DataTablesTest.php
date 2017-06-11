<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2015-2017 Artem Rodygin
//
//  This file is part of DataTables Symfony bundle.
//
//  You should have received a copy of the MIT License along with
//  the bundle. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace DataTables;

use Psr\Log\NullLogger;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validation;

class DataTablesTest extends \PHPUnit_Framework_TestCase
{
    /** @var \DataTables\DataTablesInterface */
    protected $datatables;

    protected function setUp()
    {
        $container = new ContainerBuilder();
        $logger    = new NullLogger();

        $validator = Validation::createValidatorBuilder()
            ->enableAnnotationMapping()
            ->getValidator();

        $container->set('logger', $logger);
        $container->set('validator', $validator);

        self::assertFalse($container->has('datatables'));

        $bundle = new DataTablesBundle();
        $bundle->build($container);

        $extension = $bundle->getContainerExtension();
        $extension->load([], $container);

        self::assertTrue($container->has('datatables'));

        $this->datatables = $container->get('datatables');

        $this->datatables->addService('testSuccess', new Handler\SuccessfulTestDataTable());
        $this->datatables->addService('testCustomData', new Handler\CustomDataTestDataTable());
        $this->datatables->addService('testException', new Handler\ExceptionTestDataTable());
        $this->datatables->addService('testInvalid', new Handler\InvalidResultsTestDataTable());
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

        self::assertEquals(json_encode($expected), json_encode($results));
    }

    public function testCustomData()
    {
        $draw = mt_rand();

        $request = new Request([
            'draw'      => $draw,
            'firstName' => 'Anna',
            'lastName'  => 'Rodygina',
            'start'     => 0,
            'length'    => 10,
            'search'    => ['value' => null, 'regex' => 'false'],
            'order'     => [],
            'columns'   => [],
        ]);

        $expected = [
            'draw'            => $draw,
            'recordsTotal'    => 100,
            'recordsFiltered' => 10,
            'data'            => [
                'firstName' => 'Anna',
                'lastName'  => 'Rodygina',
            ],
        ];

        $results = $this->datatables->handle($request, 'testCustomData');

        self::assertEquals(json_encode($expected), json_encode($results));
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
