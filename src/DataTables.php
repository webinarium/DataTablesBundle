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

        $query = new DataTableQuery();

        $query->draw    = $request->get('draw');
        $query->start   = $request->get('start');
        $query->length  = $request->get('length');
        $query->search  = $request->get('search');
        $query->order   = $request->get('order');
        $query->columns = $request->get('columns');

        $violations = $this->validator->validate($query);

        if (count($violations)) {
            $message = $violations->get(0)->getMessage();
            $this->logger->error($message, ['request']);
            throw new DataTableException($message);
        }

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

        $violations = $this->validator->validate($result);

        if (count($violations)) {
            $message = $violations->get(0)->getMessage();
            $this->logger->error($message, ['response']);
            throw new DataTableException($message);
        }

        return [
            'draw'            => $query->draw,
            'recordsTotal'    => $result->recordsTotal,
            'recordsFiltered' => $result->recordsFiltered,
            'data'            => $result->data,
        ];
    }
}
