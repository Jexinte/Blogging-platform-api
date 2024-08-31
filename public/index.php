<?php

declare(strict_types=1);

use Repository\PostRepository;
use Util\Request;
use Router\Router;
use Enumeration\Database\ConnectionInformation;
use Config\DatabaseConnection;
use Controller\PostController;
use Exceptions\ValidationException;
use Service\ValidateDataTypeService;
use Service\ValidateDataValueService;

require_once '../vendor/autoload.php';

$request = new Request();
$validationException = new ValidationException();
$validateDataTypeService = new ValidateDataTypeService($validationException);
$validateDataValueService = new ValidateDataValueService($validationException);
$database = new DatabaseConnection(ConnectionInformation::HOST,ConnectionInformation::DB_NAME,ConnectionInformation::USERNAME,ConnectionInformation::PASSWORD);
$postRepository = new PostRepository($database);

$postController = new PostController($validateDataTypeService,$validationException,$validateDataValueService,$postRepository);
$router = new Router($request,$postController);

try{
    $router->resolveAction();

}catch(ValidationException $e){
    foreach($e->getErrors() as $statusCode => $message){        
        echo json_encode([$statusCode => $message]);
        http_response_code($statusCode);
    }

}
header('Content-Type: application/json');