<?php

declare(strict_types=1);

namespace Enumeration\Message;

/**
 * PHP version 8.2
 *
 * @category Enumeration\Message
 * @package  Uri
 * @author   Yokke <mdembelepro@gmail.com>
 * @license  ISC License
 * @link     https://github.com/Jexinte/Blogging-platform-api
 */
enum Uri: string
{
    public const CREATE_WRONG_FORMAT = "In order to create a blog post the endpoint has to end with the word create";
    public const UPDATE_WRONG_FORMAT = "In order to update a blog post the endpoint has to end with an ID";
    public const DELETE_WRONG_FORMAT = "In order to delete a blog post the endpoint has to end with an ID";
    public const GET_ONE_WRONG_FORMAT = "In order to get a blog post the endpoint has to end with an ID";
    public const FIND_ALL_WRONG_FORMAT = "In order to get all blog posts the endpoint has to end with posts";
}
