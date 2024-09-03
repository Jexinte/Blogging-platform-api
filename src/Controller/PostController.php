<?php

declare(strict_types=1);

namespace Controller;

use Service\ProcessDataForService;

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
     * @param \Service\ProcessDataForService $processDataForService
     */
    public function __construct(private ProcessDataForService $processDataForService)
    {

    }



    /**
     * Summary of create
     * @param string $uri
     * @param string $json
     * @return void
     */
    public function create(string $uri, string $json): void
    {
        $this->processDataForService->post($uri, $json);
    }

    /**
     * Summary of update
     * @param string $uri
     * @param string $json
     * @return void
     */
    public function update(string $uri, string $json): void
    {
        $this->processDataForService->update($uri, $json);
    }


    public function delete(string $uri): void
    {
        $this->processDataForService->delete($uri);
    }

    /**
     * Summary of getOne
     * @param string $uri
     * @return void
     */
    public function getOne(string $uri): void
    {
        $this->processDataForService->getOne($uri);
    }
   
    public function findAll(): void
    {
        $this->processDataForService->findAll();
    }


}
