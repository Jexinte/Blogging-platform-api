<?php

declare(strict_types=1);

namespace Enumeration\Database;

/**
 * PHP version 8.2
 *
 * @category Enumeration\Database
 * @package  ConnectionInformation
 * @author   Yokke <mdembelepro@gmail.com>
 * @license  ISC License
 * @link     https://github.com/Jexinte/Blogging-platform-api
 */
enum ConnectionInformation: string
{
    public const HOST = "localhost";
    public const DB_NAME = "blogging_platform_api";
    public const USERNAME = "root";
    public const PASSWORD = "";
}
