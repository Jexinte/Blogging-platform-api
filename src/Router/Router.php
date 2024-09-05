<?php

namespace Router;

use Util\Request;
use Enumeration\Regex\Route;
use Controller\PostController;
use Twig\Loader\FilesystemLoader;
use Enumeration\Status\HttpStatus;
use Enumeration\RequestMethod\Method;

/**
 * PHP version 8.2
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
                $this->postController->sendDataToPostService($this->request->uri(), stream_get_contents($input));
                http_response_code(HttpStatus::CREATED);
                break;
            case Method::PUT:
                $this->postController->sendDataToUpdateService($this->request->uri(), stream_get_contents($input));
                http_response_code(HttpStatus::OK);
                break;
            case Method::DELETE:
                $this->postController->sendDataToDeleteService($this->request->uri());
                http_response_code(HttpStatus::NO_CONTENT);
                break;
            case Method::GET:
                $this->resolveGetRequest();
                break;

        }

    }

    /**
     * Summary of resolveGetRequest
     * @return void
     */
    public function resolveGetRequest(): void
    {
        $loader = new FilesystemLoader('../templates/documentation/');
        $twig = new \Twig\Environment($loader, [
        'cache' => false,
        ]);
        switch (true) {
            case preg_match(Route::FIND_ALL, $this->request->uri()):
                $this->postController->getPostsFromFindAllService();
                break;
            case preg_match(Route::GET_ONE, $this->request->uri()):
                $this->postController->getAPostFromGetOneService($this->request->uri());
                break;
            case preg_match(Route::FIND_BY_PARAMETER, $this->request->uri()):
                $this->postController->getPostsFromFindByParameterService($this->request->uri());
                break;
            default:
                header('Content-Type: text-plain');
                echo $twig->render('base.twig');
        }

    }


}
