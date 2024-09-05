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
 * PHP version 8.2
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
     * Summary of validatorForPostAndUpdate
     * @param string $uri
     * @param string $json
     * @param string $regexPattern
     * @param string $uriMessageWhenWrongFormat
     * @throws \Exception
     * @return \Entity\Post
     */
    public function validatorForPostAndUpdate(string $uri, string $json, string $regexPattern, string $uriMessageWhenWrongFormat): Post
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
        $post = $this->validatorForPostAndUpdate($uri, $json, Route::CREATE, Uri::CREATE_WRONG_FORMAT);

        if (is_object($post)) {
            $this->postRepository->create($post);
            $lastPostCreated = $this->postRepository->getTheLastPostCreated();
            $lastPostCreated['created_at'] = $this->formatDateTimeToIso8601($lastPostCreated['updated_at']);
            $lastPostCreated['updated_at'] = $this->formatDateTimeToIso8601($lastPostCreated['updated_at']);

            echo json_encode($lastPostCreated);
        }
    }

    /**
     * Summary of getUriId
     * @param string $uri
     * @return int
     */
    public function getUriId(string $uri): int
    {
        $lastPostOfSlash = strrpos($uri, '/');
        $id = intval(substr($uri, $lastPostOfSlash + 1));
        return $id;
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
        $post = $this->validatorForPostAndUpdate($uri, $json, Route::UPDATE, Uri::UPDATE_WRONG_FORMAT);
        $id = $this->getUriId($uri);
        $postFromDbBasedOnIdFromTheUri = $this->postRepository->findBy($id);
        if (is_object($post)) {

            switch (is_array($postFromDbBasedOnIdFromTheUri)) {
                case true:
                    $this->postRepository->update($post, $id);
                    $postUpdated = $this->postRepository->findBy($id);
                    $postUpdated['created_at'] = $this->formatDateTimeToIso8601($postUpdated['updated_at']);
                    $postUpdated['updated_at'] = $this->formatDateTimeToIso8601($postUpdated['updated_at']);
                    echo json_encode($postUpdated);
                    break;

                default:
                    throw new Exception("No post found !", HttpStatus::NOT_FOUND);
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
        $id = $this->getUriId($uri);
        $postThatGonnaBeDelete = $this->postRepository->findBy($id);
        if ($this->isTheRightUri($uri, Route::DELETE, Uri::DELETE_WRONG_FORMAT) && is_array($postThatGonnaBeDelete)) {
            $this->postRepository->delete($id);
            return;
        }
        throw new Exception("No post found !", HttpStatus::NOT_FOUND);
    }

    /**
     * Summary of getOne
     * @param string $uri
     * @throws \Exception
     * @return void
     */
    public function getOne(string $uri): void
    {
        $id = $this->getUriId($uri);
        $post = $this->postRepository->findBy($id);
        if (is_array($post)) {
            $post['created_at'] = $this->formatDateTimeToIso8601($post['created_at']);
            $post['updated_at'] = $this->formatDateTimeToIso8601($post['updated_at']);

            echo json_encode($post);

            return;
        }
        throw new Exception("No post found !", HttpStatus::NOT_FOUND);
    }

    /**
     * Summary of findAll
     * @throws \Exception
     * @return void
     */
    public function findAll(): void
    {
        $posts =  $this->postRepository->findAll();
        if (empty($posts)) {
            throw new Exception("No posts have been found !", HttpStatus::NOT_FOUND);
        }

        echo json_encode($this->postsWithDateFormattedToIso8601($posts));
    }

    /**
     * Summary of formatDateTimeToIso8601
     * @param string $date
     * @return string
     */
    public function formatDateTimeToIso8601(string $date): string
    {
        return implode('T', explode(' ', $date)) . 'Z';
    }

    /**
     * Summary of findByParameter
     * @param string $uri
     * @throws \Exception
     * @return void
     */
    public function findByParameter(string $uri): void
    {
        $parameterUriValue = substr($uri, strpos($uri, "=") + 1);
        $posts = $this->postRepository->findByParameter($parameterUriValue);
        if (empty($posts)) {
            throw new Exception("No posts have been found with the term $parameterUriValue !", HttpStatus::NOT_FOUND);
        }

        echo json_encode($this->postsWithDateFormattedToIso8601($posts));
    }

    /**
     * Summary of postsWithDateFormattedToIso8601
     * @param array<string> $posts
     * @return array<string>
     */
    public function postsWithDateFormattedToIso8601(array $posts): array
    {
        foreach ($posts as $k => $post) {
            $posts[$k]['created_at'] = $this->formatDateTimeToIso8601($post['created_at']);
            $posts[$k]['updated_at'] = $this->formatDateTimeToIso8601($post['updated_at']);
        }
        return $posts;
    }

}
