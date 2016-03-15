<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2015-2016 Artem Rodygin
//
//  This file is part of DataTables Symfony bundle.
//
//  You should have received a copy of the MIT License along with
//  the bundle. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace DataTables;

use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * DataTables lookup service.
 */
class DataTables implements DataTablesInterface
{
    protected $container;
    protected $logger;
    protected $validator;

    /** @var array List of registered DataTable services. */
    protected $services = [];

    /**
     * Dependency Injection constructor.
     *
     * @param   ContainerInterface $container
     * @param   LoggerInterface    $logger
     * @param   ValidatorInterface $validator
     */
    public function __construct(
        ContainerInterface $container,
        LoggerInterface    $logger,
        ValidatorInterface $validator)
    {
        $this->container = $container;
        $this->logger    = $logger;
        $this->validator = $validator;
    }

    /**
     * Registers specified DataTable handler.
     *
     * @param   string $service Service ID of the DataTable handler.
     * @param   string $id      DataTable ID.
     */
    public function addService($service, $id)
    {
        $this->services[$id] = $service;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Request $request, $id)
    {
        $this->logger->debug('Handle DataTable request', [$id]);

        // Retrieve sent parameters.
        $params = new Parameters();

        $params->draw    = $request->get('draw');
        $params->start   = $request->get('start');
        $params->length  = $request->get('length');
        $params->search  = $request->get('search');
        $params->order   = $request->get('order');
        $params->columns = $request->get('columns');

        // Validate sent parameters.
        $violations = $this->validator->validate($params);

        if (count($violations)) {
            $message = $violations->get(0)->getMessage();
            $this->logger->error($message, ['request']);
            throw new DataTableException($message);
        }

        // Check for valid handler is registered.
        if (!array_key_exists($id, $this->services)) {
            $message = 'Unknown DataTable ID.';
            $this->logger->error($message, [$id]);
            throw new DataTableException($message);
        }

        /** @var DataTableHandlerInterface $handler */
        $handler = $this->container->get($this->services[$id]);

        if (!$handler instanceof DataTableHandlerInterface) {
            $message = 'DataTable handler must implement "DataTableHandlerInterface" interface.';
            $this->logger->error($message, [$this->services[$id]]);
            throw new DataTableException($message);
        }

        // Convert sent parameters into data model.
        $query = new DataTableQuery($params);

        // Pass the data model to the handler.
        $result = null;

        list($msec, $sec) = explode(' ', microtime());
        $timer_started    = (float) $msec + (float) $sec;

        try {
            $result = $handler->handle($query);
        }
        catch (\Exception $e) {
            $this->logger->error($e->getMessage(), [$this->services[$id]]);
            throw new DataTableException($e->getMessage());
        }
        finally {
            list($msec, $sec) = explode(' ', microtime());
            $timer_stopped    = (float) $msec + (float) $sec;

            $this->logger->debug('DataTable processing time', [$timer_stopped - $timer_started, $this->services[$id]]);
        }

        // Validate results returned from handler.
        $violations = $this->validator->validate($result);

        if (count($violations)) {
            $message = $violations->get(0)->getMessage();
            $this->logger->error($message, ['response']);
            throw new DataTableException($message);
        }

        // Convert results into array as expected by DataTables plugin.
        return [
            'draw'            => (int) $params->draw,
            'recordsTotal'    => (int) $result->recordsTotal,
            'recordsFiltered' => (int) $result->recordsFiltered,
            'data'            => $result->data,
        ];
    }
}
