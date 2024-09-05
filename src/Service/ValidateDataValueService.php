<?php

declare(strict_types=1);

namespace Service;

use Exception;
use Enumeration\Status\HttpStatus;
use Enumeration\Regex\StringPattern;
use Enumeration\Message\Field as Message;

/**
 * PHP version 8.2
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
     * Summary of checkTagsPatternValues
     * @param array<array<string>> $tags
     * @throws \Exception
     * @return bool
     */
    public function checkTagsPatternValues(array $tags = null): bool
    {
        $isAllValuesHaveTheSamePattern = array_map(fn ($tag) =>  preg_match(StringPattern::FORMAT, $tag), $tags['tags']);

        if (!in_array(false, $isAllValuesHaveTheSamePattern)) {
            return true;
        }
        throw new Exception(Message::WRONG_FORMAT_FOR_TAGS, HttpStatus::BAD_REQUEST);
    }


    /**
     * Summary of isPatternValueMatch
     * @param string $pattern
     * @param mixed $value
     * @param string $exceptionMessage
     * @throws \Exception
     * @return bool
     */
    public function isPatternValueMatch(string $pattern, mixed $value, string $exceptionMessage): bool
    {
        if (preg_match($pattern, $value)) {
            return true;
        }
        throw new Exception($exceptionMessage, HttpStatus::BAD_REQUEST);

    }

    /**
     * Summary of isValueNotEmpty
     * @param mixed $value
     * @param string $exceptionMessage
     * @throws \Exception
     * @return bool
     */
    public function isValueNotEmpty(mixed $value, string $exceptionMessage): bool
    {
        if (empty($value)) {
            throw new Exception($exceptionMessage, HttpStatus::BAD_REQUEST);
        }
        return true;
    }

    /**
     * Summary of isAllValuesDataAreValids
     * @param string $json
     * @return bool
     */
    public function isAllValuesDataAreValids(string $json): bool
    {
        $arr = json_decode($json, true);
        $status = false;
        if (is_array($arr) && count($arr) == 4) {
            $isTitleNotEmpty = $this->isValueNotEmpty($arr['title'], Message::EMPTY_TITLE);
            $isTitlePatternValid = $this->isPatternValueMatch(StringPattern::FORMAT, $arr['title'], Message::WRONG_FORMAT_FOR_TITLE);
            $isContentNotEmpty = $this->isValueNotEmpty($arr['content'], Message::EMPTY_CONTENT);
            $isContentPatternValid = $this->isPatternValueMatch(StringPattern::FORMAT, $arr['content'], Message::WRONG_FORMAT_FOR_CONTENT);
            $isTagsNotEmpty = $this->isValueNotEmpty($arr['tags'], Message::EMPTY_TAGS);
            $isTagsPatternValid = $this->checkTagsPatternValues($arr);
            $isCategoryNotEmpty = $this->isValueNotEmpty($arr['category'], Message::EMPTY_CATEGORY);
            $isCategoryPatternValid = $this->isPatternValueMatch(StringPattern::FORMAT, $arr['category'], Message::WRONG_FORMAT_FOR_CATEGORY);


            if ($isTitlePatternValid && $isTitleNotEmpty && $isContentPatternValid && $isContentNotEmpty && $isTagsPatternValid && $isTagsNotEmpty && $isCategoryPatternValid && $isCategoryNotEmpty) {
                $status = true;
            }
        }
        return $status;
    }



}
