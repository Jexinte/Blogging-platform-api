<?php

declare(strict_types=1);

namespace Config;

use PDO;
use PDOException;

/**
 * PHP version 8.
 *
 * @category Config
 * @package  DatabaseConnection
 * @author   Yokke <mdembelepro@gmail.com>
 * @license  ISC License
 * @link     https://github.com/Jexinte/Blogging-platform-api
 */

class DatabaseConnection
{
    /**
     * Summary of __construct
     * @param string $host
     * @param string $dbname
     * @param string $username
     * @param string $password
     */
    public function __construct(private readonly string $host, private readonly string $dbname, private readonly string $username, private readonly string $password)
    {
    }


    /**
     * Summary of connect
     * @return PDO|string
     */
    public function connect(): PDO|string
    {
        try {
            $db = new PDO('mysql:host='.$this->host.';dbname='.$this->dbname, $this->username, $this->password);
        } catch(PDOException $e) {
            return "Database Error :" . $e->getMessage();
        }
        return $db;

    }
}
