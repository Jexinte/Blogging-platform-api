<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Service\ValidateDataTypeService;
use Enumeration\Message\Field as Message;

/**
 * PHP version 8.
 *
 * @category tests\Functional\Service
 * @package  ValidateDataTypeServiceTest
 * @author   Yokke <mdembelepro@gmail.com>
 * @license  ISC License
 * @link     https://github.com/Jexinte/Blogging-platform-api
 */

class ValidateDataTypeServiceTest extends TestCase
{
    private ValidateDataTypeService $validateDataTypeService;

    /**
    * Summary of setUp
    * @return void
    */
    public function setUp(): void
    {
        parent::setUp();
        $this->validateDataTypeService = new ValidateDataTypeService();
    }

    /**
     * Summary of testShouldReturnTrueIfAnArrayIsSupplied
     * @return void
     */
    public function testShouldReturnTrueIfAnArrayIsSupplied(): void
    {
        $this->assertSame(true, $this->validateDataTypeService->isTagsAnArray(["tags" => []]));
    }

    /**
     * Summary of testShouldThrowAnExceptionIfAnArrayIsNotSupplied
     * @return void
     */
    public function testShouldThrowAnExceptionIfAnArrayIsNotSupplied(): void
    {
        $this->expectException(Exception::class);
        $this->validateDataTypeService->isTagsAnArray(["tags" => ""]);
    }
    /**
     * Summary of testShouldReturnTheMessageExceptionIfAnArrayIsNotSupplied
     * @return void
     */
    public function testShouldReturnTheMessageExceptionIfAnArrayIsNotSupplied(): void
    {

        try {
            $this->validateDataTypeService->isTagsAnArray(["tags" => ""]);
        } catch (Exception $e) {
            $this->assertSame(Message::TAGS_IS_NOT_AN_ARRAY, $e->getMessage());
        }
    }

    /**
     * Summary of testShouldReturnTrueIfAStringIsSupplied
     * @return void
     */
    public function testShouldReturnTrueIfAStringIsSupplied(): void
    {
        $this->assertSame(true, $this->validateDataTypeService->isValueAString("test", 'noNeedExceptionMessageForThisTest'));
    }

    /**
     * Summary of testShoulThrownAnExceptionIfAStringIsNotSupplied
     * @return void
     */
    public function testShoulThrownAnExceptionIfAStringIsNotSupplied(): void
    {
        $this->expectException(Exception::class);
        $this->validateDataTypeService->isValueAString(1, 'noNeedExceptionMessageForThisTest');
    }

    /**
     * Summary of testShouldReturnTheMessageExceptionIfAStringIsNotSupplied
     * @return void
     */
    public function testShouldReturnTheMessageExceptionIfAStringIsNotSupplied(): void
    {

        try {
            $this->validateDataTypeService->isValueAString(1, "The value is not a string!");
        } catch (Exception $e) {
            $this->assertSame("The value is not a string!", $e->getMessage());
        }
    }

    /**
     * Summary of testShouldReturnTrueIfAllValuesTypesAreValids
     * @return void
     */
    public function testShouldReturnTrueIfAllValuesTypesAreValids(): void
    {
        $json = ["title" => "Title","content" => "Example Content","tags" => ["Test"],"category" => "Category"];

        $this->assertSame(true, $this->validateDataTypeService->isAllValuesTypesAreValids(json_encode($json)));

    }

    /**
     * Summary of testShouldReturnTheSameMessageExceptionForTheTitleFieldWhenAStringIsNotSupplied
     * @return void
     */
    public function testShouldReturnTheSameMessageExceptionForTheTitleFieldWhenAStringIsNotSupplied(): void
    {

        $data = ["title" => 1,"content" => "Example Content","tags" => ["Test"],"category" => "Category"];
        $json = json_encode($data);

        try {
            $this->validateDataTypeService->isAllValuesTypesAreValids($json);
        } catch (Exception $e) {

            $this->assertSame(Message::TITLE_IS_NOT_A_STRING, $e->getMessage());
        }

    }

    /**
     * Summary of testShouldReturnTheSameMessageExceptionForTheContentFieldWhenAStringIsNotSupplied
     * @return void
     */
    public function testShouldReturnTheSameMessageExceptionForTheContentFieldWhenAStringIsNotSupplied(): void
    {

        try {
            $data = ["title" => "Title","content" => 1,"tags" => ["Test"],"category" => "Category"];
            $json = json_encode($data);
            $this->validateDataTypeService->isAllValuesTypesAreValids($json);
        } catch (Exception $e) {
            $this->assertSame(Message::CONTENT_IS_NOT_A_STRING, $e->getMessage());
        }
    }

    /**
     * Summary of testShouldReturnTheSameMessageExceptionForTheCategoryFieldWhenAStringIsNotSupplied
     * @return void
     */
    public function testShouldReturnTheSameMessageExceptionForTheCategoryFieldWhenAStringIsNotSupplied(): void
    {

        try {
            $data = ["title" => "Title","content" => "Example Content","tags" => ["Test"],"category" => 1];
            $json = json_encode($data);
            $this->validateDataTypeService->isAllValuesTypesAreValids($json);
        } catch (Exception $e) {
            $this->assertSame(Message::CATEGORY_IS_NOT_A_STRING, $e->getMessage());
        }
    }



}
