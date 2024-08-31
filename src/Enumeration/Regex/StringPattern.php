<?php

declare(strict_types=1);

namespace Enumeration\Regex;

/**
 * PHP version 8.
 *
 * @category Enumeration\Regex
 * @package  StringPattern
 * @author   Yokke <mdembelepro@gmail.com>
 * @license  ISC License
 * @link     https://github.com/Jexinte/Blogging-platform-api
 */

enum StringPattern: string
{
    public const FORMAT = '/^[A-Z]{1}[a-zA-z\s]{1,}/';
}
