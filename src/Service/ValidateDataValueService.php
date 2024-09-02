<?php

declare(strict_types=1);

namespace Service;

use Enumeration\Regex\StringPattern;
use Enumeration\Status\HttpStatus;
use Exceptions\ValidationException;
use Enumeration\Message\Field as Message;

/**
 * PHP version 8.
 *
 * @category Service
 * @package  ValidateDataValueService
 * @author   Yokke <mdembelepro@gmail.com>
 * @license  ISC License
 * @link     https://github.com/Jexinte/Blogging-platform-api
 */

class ValidateDataValueService
{
    /**
     * Summary of __construct
     * @param \Exceptions\ValidationException $validationException
     */
    public function __construct(private ValidationException $validationException)
    {

    }


    /**
     * Summary of checkTagsPatternValues
     * @param array<array<string>> $tags
     * @return bool
     */
    public function checkTagsPatternValues(array $tags = null): bool
    {
        $isAllHaveTheSamePattern = array_map(fn ($tag) =>  preg_match(StringPattern::FORMAT, $tag), $tags['tags']);

        if (!in_array(false, $isAllHaveTheSamePattern)) {
            return true;
        }
        throw $this->validationException->setTypeAndValueOfException(HttpStatus::BAD_REQUEST, Message::WRONG_FORMAT_FOR_TAGS);
    }


    /**
     * Summary of isPatternValueMatch
     * @param string $pattern
     * @param mixed $value
     * @param string $exceptionMessage
     * @return bool
     */
    public function isPatternValueMatch(string $pattern, mixed $value, string $exceptionMessage): bool
    {
        if (preg_match($pattern, $value)) {
            return true;
        }
        throw $this->validationException->setTypeAndValueOfException(HttpStatus::BAD_REQUEST, $exceptionMessage);

    }

    /**
     * Summary of isValueNotEmpty
     * @param mixed $value
     * @param string $exceptionMessage
     * @return bool
     */
    public function isValueNotEmpty(mixed $value, string $exceptionMessage): bool
    {
        if (empty($value)) {
            throw $this->validationException->setTypeAndValueOfException(HttpStatus::BAD_REQUEST, $exceptionMessage);
        }
        return true;
    }

    /**
     * Summary of isAllValuesDataAreValids
     * @param string $json
     * @return null|bool
     */
    public function isAllValuesDataAreValids(string $json): ?bool
    {
        $arr = json_decode($json, true);

        switch (true) {
            case (is_array($arr) && count($arr) == 4):
                $isTitleNotEmpty = $this->isValueNotEmpty($arr['title'], Message::EMPTY_TITLE);
                $isTitlePatternValid = $this->isPatternValueMatch(StringPattern::FORMAT, $arr['title'], Message::WRONG_FORMAT_FOR_TITLE);
                $isContentNotEmpty = $this->isValueNotEmpty($arr['content'], Message::EMPTY_CONTENT);
                $isContentPatternValid = $this->isPatternValueMatch(StringPattern::FORMAT, $arr['content'], Message::WRONG_FORMAT_FOR_CONTENT);
                $isTagsNotEmpty = $this->isValueNotEmpty($arr['tags'], Message::EMPTY_TAGS);
                $isTagsPatternValid = $this->checkTagsPatternValues($arr);
                $isCategoryNotEmpty = $this->isValueNotEmpty($arr['category'], Message::EMPTY_CATEGORY);
                $isCategoryPatternValid = $this->isPatternValueMatch(StringPattern::FORMAT, $arr['category'], Message::WRONG_FORMAT_FOR_CATEGORY);


                if ($isTitlePatternValid && $isTitleNotEmpty && $isContentPatternValid && $isContentNotEmpty && $isTagsPatternValid && $isTagsNotEmpty && $isCategoryPatternValid && $isCategoryNotEmpty) {
                    return true;
                }
                return false;
        }
        return null;
    }



}
