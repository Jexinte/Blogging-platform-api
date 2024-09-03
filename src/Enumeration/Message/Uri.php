<?php

declare(strict_types=1);

namespace Enumeration\Message;

/**
 * PHP version 8.
 *
 * @category Enumeration\Message
 * @package  Uri
 * @author   Yokke <mdembelepro@gmail.com>
 * @license  ISC License
 * @link     https://github.com/Jexinte/Blogging-platform-api
 */
enum Uri: string
{
    public const CREATE_WRONG_FORMAT = "In order to create a blog post specify the following URI : localhost/blogging-platform-api/public/index.php/create";
    public const UPDATE_WRONG_FORMAT = "In order to update a blog post specify the following URI : localhost/blogging-platform-api/public/index.php/update/idOfThePost";
    public const DELETE_WRONG_FORMAT = "In order to delete a blog post specify the following URI without a body content : localhost/blogging-platform-api/public/index.php/delete/idOfThePost";
}
