<?php

namespace Router;

use Util\Request;
use Enumeration\Message\Uri;
use Enumeration\Regex\Route;
use Controller\PostController;
use Enumeration\Status\HttpStatus;
use Service\ProcessDataForService;
use Enumeration\RequestMethod\Method;

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
            case Method::DELETE:
                $this->postController->delete($this->request->uri());
                http_response_code(HttpStatus::NO_CONTENT);
                break;
            case Method::GET:
                if (preg_match(Route::FIND_ALL, $this->request->uri())) {

                    $this->postController->findAll();
                } elseif (preg_match(Route::GET_ONE, $this->request->uri())) {
                    $this->postController->getOne($this->request->uri());
                }
                break;

        }

    }


}
