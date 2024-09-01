<?php

declare(strict_types=1);

namespace Service;

use Exceptions\ValidationException;
use Enumeration\Status\HttpStatus;
use Enumeration\Message\Field as Message;

/**
 * PHP version 8.
 *
 * @category Service
 * @package  ValidateDataTypeService
 * @author   Yokke <mdembelepro@gmail.com>
 * @license  ISC License
 * @link     https://github.com/Jexinte/Blogging-platform-api
 */

class ValidateDataTypeService
{
    /**
     * Summary of __construct
     * @param \Exceptions\ValidationException $validationException
     */
    public function __construct(private ValidationException $validationException)
    {

    }


    /**
     * Summary of isTagsAnArray
     * @param array<mixed> $arr
     * @return bool
     */
    public function isTagsAnArray(array $arr): bool
    {
        switch(true) {
            case is_array($arr["tags"]):
                return true;
            default:
                throw $this->validationException->setTypeAndValueOfException(HttpStatus::BAD_REQUEST, Message::TAGS_IS_NOT_AN_ARRAY);
        }
    }

    /**
     * Summary of isValueAString
     * @param mixed $value
     * @param string $exceptionMessage
     * @return bool
     */
    public function isValueAString(mixed $value, string $exceptionMessage): bool
    {
        switch(true) {
            case is_string($value):
                return true;
            default:
                throw $this->validationException->setTypeAndValueOfException(HttpStatus::BAD_REQUEST, $exceptionMessage);
        }
    }

    /**
     * Summary of isAllValuesTypesAreValids
     * @param string $json
     * @return null|bool
     */
    public function isAllValuesTypesAreValids(string $json): ?bool
    {
        $arr = json_decode($json, true);

        switch(true) {
            case (is_array($arr) && count($arr) == 4):
                $isTitleAValidString = $this->isValueAString($arr['title'], Message::TITLE_IS_NOT_A_STRING);
                $isContentAValidString = $this->isValueAString($arr["content"], Message::CONTENT_IS_NOT_A_STRING);
                $isTagsAValidArray = $this->isTagsAnArray($arr);
                $isCategoryAValidString = $this->isValueAString($arr["category"], Message::CATEGORY_IS_NOT_A_STRING);

                if($isTitleAValidString && $isContentAValidString && $isTagsAValidArray && $isCategoryAValidString) {
                    return true;
                }
                return false;
        }
        return null;
    }

}
