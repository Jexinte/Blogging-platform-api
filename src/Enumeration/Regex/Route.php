<?php

declare(strict_types=1);

namespace Enumeration\Regex;

/**
 * PHP version 8.
 *
 * @category Enumeration\Regex
 * @package  Route
 * @author   Yokke <mdembelepro@gmail.com>
 * @license  ISC License
 * @link     https://github.com/Jexinte/Blogging-platform-api
 */

enum Route: string
{
    public const CREATE = '/\/blogging\-platform\-api\/public\/index\.php\/create$/';
    public const UPDATE = '/\/blogging\-platform\-api\/public\/index\.php\/update\/\d+$/';
    public const DELETE = '/\/blogging\-platform\-api\/public\/index\.php\/delete\/\d+$/';

}
