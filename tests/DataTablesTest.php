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

use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validation;

class DataTablesTest extends TestCase
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

        $this->datatables->addService(new Handler\SuccessfulTestDataTable(), 'testSuccess');
        $this->datatables->addService(new Handler\AutoloadedTestDataTable());
        $this->datatables->addService(new Handler\CustomDataTestDataTable(), 'testCustomData');
        $this->datatables->addService(new Handler\ExceptionTestDataTable(), 'testException');
        $this->datatables->addService(new Handler\InvalidResultsTestDataTable(), 'testInvalid');
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

    public function testAutoloaded()
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
            'recordsTotal'    => 200,
            'recordsFiltered' => 20,
            'data'            => [],
        ];

        $results = $this->datatables->handle($request, 'testAuto');

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

    public function testPost()
    {
        $draw = mt_rand();

        $request = new Request([], [
            'draw'      => $draw,
            'firstName' => 'Anna',
            'lastName'  => 'Rodygina',
            'start'     => 0,
            'length'    => 10,
            'search'    => ['value' => null, 'regex' => 'false'],
            'order'     => [],
            'columns'   => [],
        ]);

        $request->setMethod(Request::METHOD_POST);

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

    public function testException()
    {
        $this->expectException(DataTableException::class);
        $this->expectExceptionMessage('Something gone wrong.');

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

    public function testBadQuery()
    {
        $this->expectException(DataTableException::class);
        $this->expectExceptionMessage('This value should not be null.');

        $request = new Request([
            'start'   => 0,
            'length'  => 10,
            'search'  => ['value' => null, 'regex' => 'false'],
            'order'   => [],
            'columns' => [],
        ]);

        $this->datatables->handle($request, 'testSuccess');
    }

    public function testUnknownService()
    {
        $this->expectException(DataTableException::class);
        $this->expectExceptionMessage('Unknown DataTable ID.');

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

    public function testInvalidResults()
    {
        $this->expectException(DataTableException::class);
        $this->expectExceptionMessage('This value should not be null.');

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
