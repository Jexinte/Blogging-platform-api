<?php

declare(strict_types=1);

namespace Util;

/**
 * PHP version 8.
 *
 * @category Util
 * @package  Request
 * @author   Yokke <mdembelepro@gmail.com>
 * @license  ISC License
 * @link     https://github.com/Jexinte/Blogging-platform-api
 */

class Request
{
    /**
     * Summary of post
     * @return array<string>
     */
    public function post(): array
    {
        return $_POST;
    }

    /**
     * Summary of get
     * @return array<string>
     */
    public function get(): array
    {
        return $_GET;
    }

    /**
     * Summary of uri
     * @return string
     */
    public function uri(): string
    {
        return $_SERVER['REQUEST_URI'];
    }

    /**
     * Summary of method
     * @return string
     */
    public function method(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

}
