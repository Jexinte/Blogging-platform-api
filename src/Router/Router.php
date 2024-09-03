<?php

namespace Router;

use Util\Request;
use Controller\PostController;
use Enumeration\RequestMethod\Method;
use Enumeration\Status\HttpStatus;

/**
 * PHP version 8.
 *
 * @category Router
 * @package  Router
 * @author   Yokke <mdembelepro@gmail.com>
 * @license  ISC License
 * @link     https://github.com/Jexinte/Blogging-platform-api
 */

class Router
{
    /**
     * Summary of __construct
     * @param \Util\Request $request
     * @param \Controller\PostController $postController
     */
    public function __construct(private Request $request, private PostController $postController)
    {
    }


    /**
     * Summary of resolveAction
     * @return void
     */
    public function resolveAction(): void
    {

        $input = fopen('php://input', 'r');

        switch ($this->request->method()) {
            case Method::POST:
                $this->postController->create($this->request->uri(), stream_get_contents($input));
                http_response_code(HttpStatus::CREATED);
                break;
            case Method::PUT:
                $this->postController->update($this->request->uri(), stream_get_contents($input));
                http_response_code(HttpStatus::OK);
                break;

        }

    }


}
