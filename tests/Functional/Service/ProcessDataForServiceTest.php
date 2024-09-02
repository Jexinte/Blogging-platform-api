<?php

declare(strict_types=1);

use Enumeration\Message\Uri;
use Enumeration\Regex\Route;
use Config\DatabaseConnection;
use Repository\PostRepository;
use PHPUnit\Framework\TestCase;
use Service\ProcessDataForService;
use Exceptions\ValidationException;
use Service\ValidateDataTypeService;
use Service\ValidateDataValueService;
use Enumeration\Message\Field as Message;
use Enumeration\Database\ConnectionInformation;

/**
 * PHP version 8.
 *
 * @category tests\Functional\Service
 * @package  ProcessDataForServiceTest
 * @author   Yokke <mdembelepro@gmail.com>
 * @license  ISC License
 * @link     https://github.com/Jexinte/Blogging-platform-api
 */

class ProcessDataForServiceTest extends TestCase
{
    private ValidateDataTypeService $validateDataTypeService;
    private ValidateDataValueService $validateDataValueService;
    private ValidationException $validationException;
    private PostRepository $postRepository;
    private DatabaseConnection $database;
    private ProcessDataForService $processDataForService;

    public const URI_CREATE = "/blogging-platform-api/public/index.php/create";

    /**
    * Summary of setUp
    * @return void
    */
    public function setUp(): void
    {
        parent::setUp();
        $this->validationException = new ValidationException();
        $this->validateDataTypeService = new ValidateDataTypeService($this->validationException);
        $this->validateDataValueService = new ValidateDataValueService($this->validationException);
        $this->database = new DatabaseConnection(ConnectionInformation::HOST,ConnectionInformation::DB_NAME,ConnectionInformation::USERNAME,ConnectionInformation::PASSWORD);
        $this->postRepository = new PostRepository($this->database);
        $this->processDataForService = new ProcessDataForService($this->validateDataTypeService,$this->validateDataValueService,$this->validationException,$this->postRepository);
    }

    /**
     * Summary of testShouldReturnTrueIfTheUriIsCorrectlySupplied
     * @return void
     */
    public function testShouldReturnTrueIfTheUriIsCorrectlySuppliedWhenCreatingAPost():void
    {
        
        $this->assertEquals(true,$this->processDataForService->isTheRightUri(self::URI_CREATE,Route::CREATE,Uri::CREATE_WRONG_FORMAT));
    }

    /**
     * Summary of testShouldThrownAnExceptionIfTheUriIsWronglySupplied
     * @return void
     */
    public function testShouldThrownAnExceptionIfTheUriIsWronglySuppliedWhenCreatingAPost():void
    {
        
        $this->expectException(ValidationException::class);
        $this->processDataForService->isTheRightUri("bad url",Route::CREATE,Uri::CREATE_WRONG_FORMAT);
    }

    /**
     * Summary of testShouldReturnTheSameExceptionMessageIfTheUriIsWronglySupplied
     * @return void
     */
    public function testShouldReturnTheSameExceptionMessageIfTheUriIsWronglySuppliedWhenCreatingPost():void
    {
        
        try{
            $this->processDataForService->isTheRightUri("bad url",Route::CREATE,Uri::CREATE_WRONG_FORMAT);
        } catch(ValidationException $e){
            $actualMessage = current($e->getErrors());
            $this->assertSame(Uri::CREATE_WRONG_FORMAT, $actualMessage);
        }

    }
    
    /**
     * Summary of testShouldReturnAnObjectIfEverythingIsValidWhenCreatingAPost
     * @return void
     */
    public function testShouldReturnAnObjectIfEverythingIsValidWhenCreatingAPost():void
    {
        $json = ["title" => "Title","content" => "Example Content","tags" => ["Test"],"category" => "Category"];
        $this->assertIsObject($this->processDataForService->validator(self::URI_CREATE,json_encode($json),Route::CREATE,Uri::CREATE_WRONG_FORMAT));
    }

    /**
     * Summary of testShoulThrownAnExceptionIfNothingAtAllIsSentWhenCreatingAPost
     * @return void
     */
    public function testShoulThrownAnExceptionIfNothingAtAllIsSentWhenCreatingAPost():void
    {
        $json = ["title" => "","content" => "","tags" => [],"category" => ""];
        $this->expectException(ValidationException::class);
        $this->processDataForService->validator(self::URI_CREATE,json_encode($json),Route::CREATE,Uri::CREATE_WRONG_FORMAT);
    }

    /**
     * Summary of testShouldReturnTheSameExceptionMessageIfNothingAtAllIsSentWhenCreatingPost
     * @return void
     */
    public function testShouldReturnTheSameExceptionMessageIfNothingAtAllIsSentWhenCreatingPost():void
    {
        $json = [];
        try{
            $this->processDataForService->validator(self::URI_CREATE,json_encode($json),Route::CREATE,Uri::CREATE_WRONG_FORMAT);
        } catch(ValidationException $e){
            $actualMessage = current($e->getErrors());
            $this->assertSame(Message::ALL_FIELDS_MUST_BE_FILLED, $actualMessage);
        }

    }

}