<?php

declare(strict_types=1);

namespace Service;

use Exception;
use Entity\Post;
use Enumeration\Message\Uri;
use Enumeration\Regex\Route;
use Repository\PostRepository;
use Enumeration\Status\HttpStatus;
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
     * @param \Repository\PostRepository $postRepository
     */
    public function __construct(private ValidateDataTypeService $validateDataTypeService, private ValidateDataValueService $validateDataValueService, private PostRepository $postRepository)
    {

    }

    /**
     * Summary of isTheRightUri
     * @param string $uri
     * @param string $pattern
     * @param string $message
     * @throws \Exception
     * @return bool
     */
    public function isTheRightUri(string $uri, string $pattern, string $message): bool
    {
        if (preg_match($pattern, $uri)) {
            return true;
        }
        throw new Exception($message, HttpStatus::BAD_REQUEST);

    }

    /**
     * Summary of validator
     * @param string $uri
     * @param string $json
     * @param string $regexPattern
     * @param string $uriMessageWhenWrongFormat
     * @throws \Exception
     * @return \Entity\Post
     */
    public function validator(string $uri, string $json, string $regexPattern, string $uriMessageWhenWrongFormat): Post
    {
        if ($this->isTheRightUri($uri, $regexPattern, $uriMessageWhenWrongFormat) && $this->validateDataTypeService->isAllValuesTypesAreValids($json) && $this->validateDataValueService->isAllValuesDataAreValids($json)) {
            $dataFromJson = json_decode($json, true);
            $post = new Post($dataFromJson['title'], $dataFromJson['content'], $dataFromJson['category'], $dataFromJson['tags']);
            return $post;
        }

        throw new Exception(Message::ALL_FIELDS_MUST_BE_FILLED, HttpStatus::BAD_REQUEST);

    }

    /**
     * Summary of post
     * @param string $uri
     * @param string $json
     * @return void
     */
    public function post(string $uri, string $json): void
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
     * @throws \Exception
     * @return void
     */
    public function update(string $uri, string $json): void
    {
        $post = $this->validator($uri, $json, Route::UPDATE, Uri::UPDATE_WRONG_FORMAT);
        if (is_object($post)) {
            $lastPostOfSlash = strrpos($uri, '/');
            $id = intval(substr($uri, $lastPostOfSlash + 1));
            $postFromDbBasedOnIdFromTheUri = $this->postRepository->findBy($id);

            switch (true) {
                case is_array($postFromDbBasedOnIdFromTheUri):
                    $this->postRepository->update($post, $id);

                    $output = fopen('php://output', 'w');

                    $postUpdated = $this->postRepository->findBy($id);
                    $postUpdated['created_at'] = implode('T', explode(' ', $postUpdated['created_at'])).'Z';
                    $postUpdated['updated_at'] = implode('T', explode(' ', $postUpdated['updated_at'])).'Z';

                    fwrite($output, json_encode($postUpdated));
                    fclose($output);

                    break;

                default:
                    throw new Exception("The resource with the id $id do not exist !", HttpStatus::NOT_FOUND);
            }

        }
    }

    /**
     * Summary of delete
     * @param string $uri
     * @throws \Exception
     * @return void
     */
    public function delete(string $uri): void
    {
        $lastPostOfSlash = strrpos($uri, '/');
        $id = intval(substr($uri, $lastPostOfSlash + 1));
        $postThatGonnaBeDelete = $this->postRepository->findBy($id);
        if ($this->isTheRightUri($uri, Route::DELETE, Uri::DELETE_WRONG_FORMAT) && is_array($postThatGonnaBeDelete)) {
            $this->postRepository->delete($id);
            return;
        }
        throw new Exception("The resource with the id $id do not exist !", HttpStatus::NOT_FOUND);
    }

    /**
     * Summary of getOne
     * @param string $uri
     * @throws \Exception
     * @return void
     */
    public function getOne(string $uri): void
    {
        $lastPostOfSlash = strrpos($uri, '/');
        $id = intval(substr($uri, $lastPostOfSlash + 1));
        $post = $this->postRepository->findBy($id);
        if (is_array($post)) {

            $output = fopen('php://output', 'w');

            $post['created_at'] = implode('T', explode(' ', $post['created_at'])).'Z';
            $post['updated_at'] = implode('T', explode(' ', $post['updated_at'])).'Z';

            fwrite($output, json_encode($post));
            fclose($output);
            return;
        }
        throw new Exception("The resource with the id $id do not exist !", HttpStatus::NOT_FOUND);
    }

}
