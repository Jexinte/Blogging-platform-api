<?php

declare(strict_types=1);

namespace Enumeration\Regex;

/**
 * PHP version 8.2
 *
 * @category Enumeration\Regex
 * @package  Route
 * @author   Yokke <mdembelepro@gmail.com>
 * @license  ISC License
 * @link     https://github.com/Jexinte/Blogging-platform-api
 */

enum Route: string
{
    public const CREATE = '/\/blogging\-platform\-api\/public\/index\.php\/api\/v1\/posts\/create$/';
    public const UPDATE = '/\/blogging\-platform\-api\/public\/index\.php\/api\/v1\/posts\/update\/\d+$/';
    public const DELETE = '/\/blogging\-platform\-api\/public\/index\.php\/api\/v1\/posts\/delete\/\d+$/';
    public const GET_ONE = '/\/blogging\-platform\-api\/public\/index\.php\/api\/v1\/posts\/\d+$/';
    public const FIND_ALL = '/\/blogging\-platform\-api\/public\/index\.php\/api\/v1\/posts$/';
    public const FIND_BY_PARAMETER = '/\/blogging\-platform\-api\/public\/index\.php\/api\/v1\/posts(?:\?term=\w+)$/';

}
