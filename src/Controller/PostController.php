<?php

declare(strict_types=1);

namespace Controller;

use Service\ProcessDataForService;

/**
 * PHP version 8.2
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
     * @param \Service\ProcessDataForService $processDataForService
     */
    public function __construct(private ProcessDataForService $processDataForService)
    {

    }



    /**
     * Summary of sendDataToPostService
     * @param string $uri
     * @param string $json
     * @return void
     */
    public function sendDataToPostService(string $uri, string $json): void
    {
        $this->processDataForService->post($uri, $json);
    }

    /**
     * Summary of sendDataToUpdateService
     * @param string $uri
     * @param string $json
     * @return void
     */
    public function sendDataToUpdateService(string $uri, string $json): void
    {
        $this->processDataForService->update($uri, $json);
    }

    /**
     * Summary of sendDataToDeleteService
     * @param string $uri
     * @return void
     */
    public function sendDataToDeleteService(string $uri): void
    {
        $this->processDataForService->delete($uri);
    }

    /**
     * Summary of getAPostFromGetOneService
     * @param string $uri
     * @return void
     */
    public function getAPostFromGetOneService(string $uri): void
    {
        $this->processDataForService->getOne($uri);
    }



    /**
     * Summary of getPostsFromFindAllService
     * @return void
     */
    public function getPostsFromFindAllService(): void
    {
        $this->processDataForService->findAll();
    }


    /**
     * Summary of getPostsFromFindByParameterService
     * @param string $uri
     * @return void
     */
    public function getPostsFromFindByParameterService(string $uri): void
    {
        $this->processDataForService->findByParameter($uri);
    }
}
