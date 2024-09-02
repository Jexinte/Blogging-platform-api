<?php

declare(strict_types=1);

namespace Service;

use Entity\Post;
use Enumeration\Message\Uri;
use Enumeration\Regex\Route;
use Repository\PostRepository;
use Enumeration\Status\HttpStatus;
use Exceptions\ValidationException;
use Enumeration\Message\Field as Message;

/**
 * PHP version 8.
 *
 * @category Service
 * @package  ProcessDataForService
 * @author   Yokke <mdembelepro@gmail.com>
 * @license  ISC License
 * @link     https://github.com/Jexinte/Blogging-platform-api
 */

class ProcessDataForService
{
    /**
     * Summary of __construct
     * @param \Service\ValidateDataTypeService $validateDataTypeService
     * @param \Service\ValidateDataValueService $validateDataValueService
     * @param \Exceptions\ValidationException $validationException
     * @param \Repository\PostRepository $postRepository
     */
    public function __construct(private ValidateDataTypeService $validateDataTypeService, private ValidateDataValueService $validateDataValueService, private ValidationException $validationException, private PostRepository $postRepository)
    {

    }

    /**
     * Summary of isTheRightUri
     * @param string $uri
     * @param string $pattern
     * @param string $message
     * @return bool
     */
    public function isTheRightUri(string $uri, string $pattern, string $message): bool
    {
        if (preg_match($pattern, $uri)) {
            return true;
        }
        throw $this->validationException->setTypeAndValueOfException(HttpStatus::BAD_REQUEST, $message);

    }

    /**
     * Summary of validator
     * @param string $uri
     * @param string $json
     * @param string $regexPattern
     * @param string $uriMessageWhenWrongFormat
     * @return \Entity\Post
     */
    public function validator(string $uri, string $json, string $regexPattern, string $uriMessageWhenWrongFormat): Post
    {
        if ($this->isTheRightUri($uri, $regexPattern, $uriMessageWhenWrongFormat) && $this->validateDataTypeService->isAllValuesTypesAreValids($json) && $this->validateDataValueService->isAllValuesDataAreValids($json)) {
            $dataFromJson = json_decode($json, true);
            $post = new Post($dataFromJson['title'], $dataFromJson['content'], $dataFromJson['category'], $dataFromJson['tags']);
            return $post;
        }
        throw $this->validationException->setTypeAndValueOfException(HttpStatus::BAD_REQUEST, Message::ALL_FIELDS_MUST_BE_FILLED);

    }

    /**
     * Summary of post
     * @param string $uri
     * @param string $json
     * @return void
     */
    public function post(string $uri, string $json)
    {
        $post = $this->validator($uri, $json, Route::CREATE, Uri::CREATE_WRONG_FORMAT);

        if (is_object($post)) {

            $this->postRepository->create($post);

            $output = fopen('php://output', 'w');

            $lastPostCreated = $this->postRepository->getTheLastPostCreated();
            $lastPostCreated['created_at'] = implode('T', explode(' ', $lastPostCreated['created_at'])).'Z';
            $lastPostCreated['updated_at'] = implode('T', explode(' ', $lastPostCreated['updated_at'])).'Z';

            fwrite($output, json_encode($lastPostCreated));
            fclose($output);
            return;
        }
    }


    /**
     * Summary of update
     * @param string $uri
     * @param string $json
     * @return void
     */
    public function update(string $uri, string $json)
    {
        $post = $this->validator($uri, $json, Route::UPDATE, Uri::UPDATE_WRONG_FORMAT);

        if (is_object($post)) {
            $lastPostOfSlash = strrpos($uri,'/');
            $id = intval(substr($uri,$lastPostOfSlash + 1));
            $postFromDbBasedOnIdFromTheUri = $this->postRepository->findBy($id);

            switch(true) {
                case is_array($postFromDbBasedOnIdFromTheUri):
                    $this->postRepository->update($post,$id);

                    $output = fopen('php://output', 'w');

                    $postUpdated = $this->postRepository->findBy($id);
                    $postUpdated['created_at'] = implode('T', explode(' ', $postUpdated['created_at'])).'Z';
                    $postUpdated['updated_at'] = implode('T', explode(' ', $postUpdated['updated_at'])).'Z';
        
                    fwrite($output, json_encode($postUpdated));
                    fclose($output);

                    break;

                default:
                throw $this->validationException->setTypeAndValueOfException(HttpStatus::NOT_FOUND,"The resource with the id $id do not exist !");
            }
            
        }
    }

}
