<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2015-2019 Artem Rodygin
//
//  This file is part of DataTables Symfony bundle.
//
//  You should have received a copy of the MIT License along with
//  the bundle. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace DataTables;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Parameters received from DataTables plugin.
 *
 * @see https://www.datatables.net/manual/server-side
 *
 * @property int   $draw       Draw counter
 * @property int   $start      Index of first row to return, zero-based
 * @property int   $length     Total number of rows to return (-1 to return all rows)
 * @property array $search     Global search value
 * @property array $order      Columns ordering (zero-based column index and direction)
 * @property array $columns    Columns information (searchable, orderable, search value, etc)
 * @property array $customData Custom data from DataTables
 */
class Parameters
{
    /**
     * @Assert\NotNull
     * @Assert\GreaterThanOrEqual(value="0")
     */
    public $draw = 0;

    /**
     * @Assert\NotNull
     * @Assert\GreaterThanOrEqual(value="0")
     */
    public $start = 0;

    /**
     * @Assert\NotNull
     * @Assert\GreaterThanOrEqual(value="-1")
     */
    public $length = -1;

    /**
     * @Assert\NotNull
     * @Assert\Collection(
     *     fields={
     *         "value": {
     *             @Assert\Length(max="100")
     *         },
     *         "regex": {
     *             @Assert\Choice(choices={"false", "true"}, strict=true)
     *         }
     *     },
     *     allowExtraFields=false,
     *     allowMissingFields=false
     * )
     */
    public $search = [];

    /**
     * @Assert\NotNull
     * @Assert\Type(type="array")
     * @Assert\All({
     *     @Assert\Collection(
     *         fields={
     *             "column": {
     *                 @Assert\GreaterThanOrEqual(value="0")
     *             },
     *             "dir": {
     *                 @Assert\Choice(choices={"asc", "desc"}, strict=true)
     *             }
     *         },
     *         allowExtraFields=false,
     *         allowMissingFields=false
     *     )
     * })
     */
    public $order = [];

    /**
     * @Assert\NotNull
     * @Assert\Type(type="array")
     * @Assert\All({
     *     @Assert\Collection(
     *         fields={
     *             "data": {
     *             },
     *             "name": {
     *                 @Assert\Length(max="100")
     *             },
     *             "searchable": {
     *                 @Assert\Choice(choices={"false", "true"}, strict=true)
     *             },
     *             "orderable": {
     *                 @Assert\Choice(choices={"false", "true"}, strict=true)
     *             },
     *             "search": {
     *                 @Assert\Collection(
     *                     fields={
     *                         "value": {
     *                             @Assert\Length(max="100")
     *                         },
     *                         "regex": {
     *                             @Assert\Choice(choices={"false", "true"}, strict=true)
     *                         }
     *                     },
     *                     allowExtraFields=false,
     *                     allowMissingFields=false
     *                 )
     *             }
     *         },
     *         allowExtraFields=false,
     *         allowMissingFields=false
     *     )
     * })
     */
    public $columns = [];

    /**
     * @Assert\Type(type="array")
     */
    public $customData = [];
}
