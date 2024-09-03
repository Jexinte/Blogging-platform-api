<?php

declare(strict_types=1);

namespace Enumeration\RequestMethod;

/**
 * PHP version 8.
 *
 * @category Enumeration\RequestMethod
 * @package  Method
 * @author   Yokke <mdembelepro@gmail.com>
 * @license  ISC License
 * @link     https://github.com/Jexinte/Blogging-platform-api
 */

enum Method: string
{
    public const POST = 'POST';
    public const PUT = "PUT";
    public const DELETE = "DELETE";
    public const GET = "GET";

}
