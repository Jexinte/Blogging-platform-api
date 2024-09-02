<?php

declare(strict_types=1);

use Repository\PostRepository;
use Service\ProcessDataForService;
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

$database = new DatabaseConnection(ConnectionInformation::HOST,ConnectionInformation::DB_NAME,ConnectionInformation::USERNAME,ConnectionInformation::PASSWORD);
$postRepository = new PostRepository($database);

$validateDataTypeService = new ValidateDataTypeService($validationException);
$validateDataValueService = new ValidateDataValueService($validationException);
$processDataForService = new ProcessDataForService($validateDataTypeService,$validateDataValueService,$validationException,$postRepository);


$postController = new PostController($processDataForService);

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