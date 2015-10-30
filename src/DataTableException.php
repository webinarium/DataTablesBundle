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

use Symfony\Component\HttpFoundation\Response;

/**
 * Exception in last DataTable request handling.
 * Contains HTTP status code and can be used in HTTP Response object.
 */
class DataTableException extends \Exception
{
    /**
     * {@inheritdoc}
     */
    public function __construct($message, $code = Response::HTTP_BAD_REQUEST, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
