<?php

declare(strict_types=1);

namespace Controller;

use Entity\Post;

use Util\Request;
use Enumeration\Message\Uri;
use Enumeration\Regex\Route;
use Repository\PostRepository;
use Enumeration\Status\HttpStatus;
use Exceptions\ValidationException;
use Service\ValidateDataTypeService;
use Service\ValidateDataValueService;

/**
 * PHP version 8.
 *
 * @category Controller
 * @package  PostController
 * @author   Yokke <mdembelepro@gmail.com>
 * @license  ISC License
 * @link     https://github.com/Jexinte/Blogging-platform-api
 */

class PostController
{
    /**
     * Summary of __construct
     * @param \Service\ValidateDataTypeService $validateDataTypeService
     * @param \Exceptions\ValidationException $validationException
     * @param \Service\ValidateDataValueService $validateDataValueService
     * @param \Repository\PostRepository $postRepository
     */
    public function __construct(private ValidateDataTypeService $validateDataTypeService, private ValidationException $validationException, private ValidateDataValueService $validateDataValueService, private PostRepository $postRepository)
    {

    }

    /**
     * Summary of isTheRightUri
     * @param string $uri
     * @param string $pattern
     * @return bool
     */
    public function isTheRightUri(string $uri, string $pattern): bool
    {
        if(preg_match($pattern, $uri)) {
            return true;
        }
        throw $this->validationException->setTypeAndValueOfException(HttpStatus::BAD_REQUEST, Uri::WRONG_FORMAT);

    }

    /**
     * Summary of create
     * @param string $uri
     * @param string $json
     * @return void
     */
    public function create(string $uri, string $json): void
    {
        $isUriValid = $this->isTheRightUri($uri, Route::CREATE);

        if($isUriValid && $this->validator($json)) {

            $dataFromJson = json_decode($json, true);
            $post = new Post($dataFromJson['title'], $dataFromJson['content'], $dataFromJson['category'], $dataFromJson['tags']);
            $this->postRepository->create($post);

            $output = fopen('php://output', 'w');

            $lastPostCreated = $this->postRepository->getTheLastPostCreated();
            $lastPostCreated['created_at'] = implode('T', explode(' ', $lastPostCreated['created_at'])).'Z';
            $lastPostCreated['updated_at'] = implode('T', explode(' ', $lastPostCreated['updated_at'])).'Z';

            fwrite($output, json_encode($lastPostCreated));
            fclose($output);
        }
    }
    /**
     * Summary of validator
     * @param string $json
     * @return bool
     */
    public function validator(string $json): ?bool
    {
        if($this->validateDataTypeService->isAllValuesTypesAreValids($json) && $this->validateDataValueService->isAllValuesDataAreValids($json)) {
            return true;
        }
        return null;
    }
}
