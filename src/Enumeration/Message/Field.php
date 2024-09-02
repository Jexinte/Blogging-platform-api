<?php

declare(strict_types=1);

namespace Enumeration\Message;

/**
 * PHP version 8.
 *
 * @category Enumeration\Message
 * @package  Field
 * @author   Yokke <mdembelepro@gmail.com>
 * @license  ISC License
 * @link     https://github.com/Jexinte/Blogging-platform-api
 */
enum Field: string
{
    public const TITLE_IS_NOT_A_STRING = "The title value have to be a string !";
    public const CONTENT_IS_NOT_A_STRING = "The content value have to be a string !";
    public const TAGS_IS_NOT_AN_ARRAY = "The tags value have to be an array!";
    public const CATEGORY_IS_NOT_A_STRING = "The category value have to be a string!";
    public const WRONG_FORMAT_FOR_TITLE = "The title of the post have to start with an uppercase letter !";
    public const WRONG_FORMAT_FOR_CONTENT = "The content of the post have to start with an uppercase letter !";
    public const WRONG_FORMAT_FOR_CATEGORY = "The category of the post have to start with an uppercase letter !";
    public const WRONG_FORMAT_FOR_TAGS = "Each tag have to start with an uppercase letter !";
    public const EMPTY_TITLE = "The title field cannot be empty !";
    public const EMPTY_CONTENT = "The content field cannot be empty !";
    public const EMPTY_TAGS = "The tags field cannot be empty !";
    public const EMPTY_CATEGORY = "The category field cannot be empty !";
    public const ALL_FIELDS_MUST_BE_FILLED = "All fields must be filled !";
}
