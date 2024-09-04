<?php

declare(strict_types=1);

namespace Enumeration\Status;

/**
 * PHP version 8.2
 *
 * @category Enumeration\Status
 * @package  HttpStatus
 * @author   Yokke <mdembelepro@gmail.com>
 * @license  ISC License
 * @link     https://github.com/Jexinte/Blogging-platform-api
 */

enum HttpStatus: string
{
    public const OK = 200;
    public const CREATED = 201;
    public const NO_CONTENT = 204;
    public const BAD_REQUEST = 400;
    public const NOT_FOUND = 404;
}
