<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2015-2022 Artem Rodygin
//
//  This file is part of DataTables Symfony bundle.
//
//  You should have received a copy of the MIT License along with
//  the bundle. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace DataTables;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Exception from a DataTable request handling.
 * Contains HTTP status code and can be used in HTTP Response object.
 */
class DataTableException extends BadRequestHttpException
{
    /**
     * {@inheritdoc}
     */
    public function __construct(string $message, int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $previous, $code);
    }
}
