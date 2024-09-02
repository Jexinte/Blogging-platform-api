<?php

declare(strict_types=1);

use Exceptions\ValidationException;
use PHPUnit\Framework\TestCase;
use Service\ValidateDataValueService;
use Enumeration\Message\Field as Message;
use Enumeration\Regex\StringPattern;

/**
 * PHP version 8.
 *
 * @category tests\Functional\Service
 * @package  validateDataValueServiceTest
 * @author   Yokke <mdembelepro@gmail.com>
 * @license  ISC License
 * @link     https://github.com/Jexinte/Blogging-platform-api
 */

class ValidateDataValueServiceTest extends TestCase
{
    private ValidateDataValueService $validateDataValueService;
    private ValidationException $validationException;

    /**
    * Summary of setUp
    * @return void
    */
    public function setUp(): void
    {
        parent::setUp();
        $this->validationException = new ValidationException();
        $this->validateDataValueService = new ValidateDataValueService($this->validationException);
    }

    /**
     * Summary of testShouldReturnTrueIfTagsPatternIsRespected
     * @return void
     */
    public function testShouldReturnTrueIfTagsPatternIsRespected(): void
    {
        $arr = ["title" => "Title","content" => "Example Content","tags" => ["Test"],"category" => "Category"];
        $this->assertSame(true, $this->validateDataValueService->checkTagsPatternValues($arr));
    }

    /**
     * Summary of testShouldThrownAnExceptionIfTagsPatternIsNotRespected
     * @return void
     */
    public function testShouldThrownAnExceptionIfTagsPatternIsNotRespected(): void
    {
        $arr = ["title" => "Title","content" => "Example Content","tags" => ["test"],"category" => "Category"];
        $this->expectException(ValidationException::class);
        $this->validateDataValueService->checkTagsPatternValues($arr);
    }

    /**
     * Summary of testShouldReturnTheSameMessageExceptionIfTagsPatternIsNotRespected
     * @return void
     */
    public function testShouldReturnTheSameMessageExceptionIfTagsPatternIsNotRespected(): void
    {
        try {
            $arr = ["title" => "Title","content" => "Example Content","tags" => ["test"],"category" => "Category"];
            $this->validateDataValueService->checkTagsPatternValues($arr);
        } catch (ValidationException $e) {
            $actualMessage = current($e->getErrors());
            $this->assertSame(Message::WRONG_FORMAT_FOR_TAGS, $actualMessage);
        }
    }

    /**
     * Summary of testShouldReturnTrueIfTitlePatternValueMatch
     * @return void
     */
    public function testShouldReturnTrueIfTitlePatternValueMatch(): void
    {
        $arr = ["title" => "Title","content" => "Example Content","tags" => ["Test"],"category" => "Category"];
        $this->assertSame(true, $this->validateDataValueService->isPatternValueMatch(StringPattern::FORMAT, $arr['title'], Message::WRONG_FORMAT_FOR_TITLE));
    }

    /**
     * Summary of testShouldThrownAnExceptionIfTitlePatternValueIsNotRespected
     * @return void
     */
    public function testShouldThrownAnExceptionIfTitlePatternValueIsNotRespected(): void
    {
        $arr = ["title" => "title","content" => "Example Content","tags" => ["Test"],"category" => "Category"];
        $this->expectException(ValidationException::class);
        $this->validateDataValueService->isPatternValueMatch(StringPattern::FORMAT, $arr['title'], Message::WRONG_FORMAT_FOR_TITLE);
    }


    /**
     * Summary of testShouldReturnTheSameMessageExceptionIfTitlePatternIsNotRespected
     * @return void
     */
    public function testShouldReturnTheSameMessageExceptionIfTitlePatternIsNotRespected(): void
    {
        $arr = ["title" => "title","content" => "Example Content","tags" => ["Test"],"category" => "Category"];
        try {
            $this->validateDataValueService->isPatternValueMatch(StringPattern::FORMAT, $arr['title'], Message::WRONG_FORMAT_FOR_TITLE);
        } catch (ValidationException $e) {
            $actualMessage = current($e->getErrors());
            $this->assertSame(Message::WRONG_FORMAT_FOR_TITLE, $actualMessage);
        }
    }

    /**
     * Summary of testShouldReturnTrueIfContentPatternValueMatch
     * @return void
     */
    public function testShouldReturnTrueIfContentPatternValueMatch(): void
    {
        $arr = ["title" => "Title","content" => "Example Content","tags" => ["Test"],"category" => "Category"];
        $this->assertSame(true, $this->validateDataValueService->isPatternValueMatch(StringPattern::FORMAT, $arr['content'], Message::WRONG_FORMAT_FOR_CONTENT));
    }

    /**
     * Summary of testShouldThrownAnExceptionIfContentPatternValueIsNotRespected
     * @return void
     */
    public function testShouldThrownAnExceptionIfContentPatternValueIsNotRespected(): void
    {
        $arr = ["title" => "Title","content" => "content","tags" => ["Test"],"category" => "Category"];
        $this->expectException(ValidationException::class);
        $this->validateDataValueService->isPatternValueMatch(StringPattern::FORMAT, $arr['content'], Message::WRONG_FORMAT_FOR_CONTENT);
    }

    /**
     * Summary of testShouldReturnTheSameMessageExceptionIfContentPatternIsNotRespected
     * @return void
     */
    public function testShouldReturnTheSameMessageExceptionIfContentPatternIsNotRespected(): void
    {
        $arr = ["title" => "Title","content" => "content","tags" => ["Test"],"category" => "Category"];
        try {
            $this->validateDataValueService->isPatternValueMatch(StringPattern::FORMAT, $arr['content'], Message::WRONG_FORMAT_FOR_CONTENT);
        } catch (ValidationException $e) {
            $actualMessage = current($e->getErrors());
            $this->assertSame(Message::WRONG_FORMAT_FOR_CONTENT, $actualMessage);
        }
    }

    /**
     * Summary of testShouldReturnTrueIfCategoryPatternValueMatch
     * @return void
     */
    public function testShouldReturnTrueIfCategoryPatternValueMatch(): void
    {
        $arr = ["title" => "Title","content" => "Example Content","tags" => ["Test"],"category" => "Category"];
        $this->assertSame(true, $this->validateDataValueService->isPatternValueMatch(StringPattern::FORMAT, $arr['category'], Message::WRONG_FORMAT_FOR_CATEGORY));
    }

    /**
     * Summary of testShouldThrownAnExceptionIfCategoryPatternValueIsNotRespected
     * @return void
     */
    public function testShouldThrownAnExceptionIfCategoryPatternValueIsNotRespected(): void
    {
        $arr = ["title" => "Title","content" => "content","tags" => ["Test"],"category" => "category"];
        $this->expectException(ValidationException::class);
        $this->validateDataValueService->isPatternValueMatch(StringPattern::FORMAT, $arr['category'], Message::WRONG_FORMAT_FOR_CATEGORY);
    }

    /**
     * Summary of testShouldReturnTheSameMessageExceptionIfCategoryPatternIsNotRespected
     * @return void
     */
    public function testShouldReturnTheSameMessageExceptionIfCategoryPatternIsNotRespected(): void
    {
        $arr = ["title" => "Title","content" => "content","tags" => ["Test"],"category" => "category"];
        try {
            $this->validateDataValueService->isPatternValueMatch(StringPattern::FORMAT, $arr['category'], Message::WRONG_FORMAT_FOR_CATEGORY);
        } catch (ValidationException $e) {
            $actualMessage = current($e->getErrors());
            $this->assertSame(Message::WRONG_FORMAT_FOR_CATEGORY, $actualMessage);
        }
    }

    /**
     * Summary of testShouldReturnTrueIfValueIsNotEmpty
     * @return void
     */
    public function testShouldReturnTrueIfValueIsNotEmpty(): void
    {
        $this->assertSame(true, $this->validateDataValueService->isValueNotEmpty("test", "no need to test the message there"));
    }

    /**
     * Summary of testShouldThrownAnExceptionIfValueIsEmpty
     * @return void
     */
    public function testShouldThrownAnExceptionIfValueIsEmpty(): void
    {
        $this->expectException(ValidationException::class);
        $this->validateDataValueService->isValueNotEmpty("", "no need to test the message there");
    }

    /**
     * Summary of testShouldReturnTheSameMessageExceptionIfValueIsEmpty
     * @return void
     */
    public function testShouldReturnTheSameMessageExceptionIfValueIsEmpty(): void
    {
        try {
            $this->validateDataValueService->isValueNotEmpty("", "the value is empty !");
        } catch (ValidationException $e) {
            $actualMessage = current($e->getErrors());
            $this->assertSame("the value is empty !", $actualMessage);
        }
    }

    /**
     * Summary of testShouldReturnTrueIfAllValuesTypesAreValids
     * @return void
     */
    public function testShouldReturnTrueIfAllValuesDataAreValids(): void
    {
        $json = ["title" => "Title","content" => "Example Content","tags" => ["Test"],"category" => "Category"];

        $this->assertSame(true, $this->validateDataValueService->isAllValuesDataAreValids(json_encode($json)));

    }

}
