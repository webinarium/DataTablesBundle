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

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * DataTables lookup service.
 */
class DataTables implements DataTablesInterface
{
    protected $logger;
    protected $validator;

    /** @var DataTableHandlerInterface[] List of registered DataTable services. */
    protected $services = [];

    /**
     * Dependency Injection constructor.
     *
     * @param LoggerInterface    $logger
     * @param ValidatorInterface $validator
     */
    public function __construct(LoggerInterface $logger, ValidatorInterface $validator)
    {
        $this->logger    = $logger;
        $this->validator = $validator;
    }

    /**
     * Registers specified DataTable handler.
     *
     * @param DataTableHandlerInterface $service Service of the DataTable handler.
     * @param string                    $id      DataTable ID.
     */
    public function addService(DataTableHandlerInterface $service, string $id = null)
    {
        $service_id = $id ?? $service::ID;

        if ($service_id !== null) {
            $this->services[$service_id] = $service;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Request $request, string $id): DataTableResults
    {
        $this->logger->debug('Handle DataTable request', [$id]);

        // Retrieve sent parameters.
        $params = new Parameters();

        $keyParams = [
            'draw',
            'start',
            'length',
            'search',
            'order',
            'columns',
        ];

        $params->draw       = $request->get('draw');
        $params->start      = $request->get('start');
        $params->length     = $request->get('length');
        $params->search     = $request->get('search');
        $params->order      = $request->get('order');
        $params->columns    = $request->get('columns');
        $params->customData = array_diff_key($request->query->all(), array_flip($keyParams));

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

        // Convert sent parameters into data model.
        $query = new DataTableQuery($params);

        // Pass the data model to the handler.
        $result = null;

        $timer_started = microtime(true);

        try {
            $result = $this->services[$id]->handle($query);
        }
        catch (\Exception $e) {
            $this->logger->error($e->getMessage(), [$this->services[$id]]);
            throw new DataTableException($e->getMessage());
        }
        finally {
            $timer_stopped = microtime(true);
            $this->logger->debug('DataTable processing time', [$timer_stopped - $timer_started, $this->services[$id]]);
        }

        // Validate results returned from handler.
        $violations = $this->validator->validate($result);

        if (count($violations)) {
            $message = $violations->get(0)->getMessage();
            $this->logger->error($message, ['response']);
            throw new DataTableException($message);
        }

        $reflection = new \ReflectionProperty(DataTableResults::class, 'draw');
        $reflection->setAccessible(true);
        $reflection->setValue($result, $params->draw);

        return $result;
    }
}
