<?php

namespace Router;

use Util\Request;
use Enumeration\Message\Uri;
use Enumeration\Regex\Route;
use Controller\PostController;
use Twig\Loader\FilesystemLoader;
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
        $loader = new FilesystemLoader('../templates/documentation/');
        $twig = new \Twig\Environment($loader, [
        'cache' => false,
        ]);

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
                } elseif (preg_match(Route::FIND_BY_PARAMETER, $this->request->uri())) {
                    $this->postController->findByParameter($this->request->uri());
                } else {
                    header('Content-Type: text-plain');
                    echo $twig->render('base.twig');
                }
                break;

        }

    }


}
