<?php

declare(strict_types=1);

use Repository\PostRepository;
use Service\ProcessDataForService;
use Util\Request;
use Router\Router;
use Enumeration\Database\ConnectionInformation;
use Config\DatabaseConnection;
use Controller\PostController;
use Service\ValidateDataTypeService;
use Service\ValidateDataValueService;

require_once '../vendor/autoload.php';

$request = new Request();

$database = new DatabaseConnection(ConnectionInformation::HOST,ConnectionInformation::DB_NAME,ConnectionInformation::USERNAME,ConnectionInformation::PASSWORD);
$postRepository = new PostRepository($database);

$validateDataTypeService = new ValidateDataTypeService();
$validateDataValueService = new ValidateDataValueService();
$processDataForService = new ProcessDataForService($validateDataTypeService,$validateDataValueService,$postRepository);


$postController = new PostController($processDataForService);

$router = new Router($request,$postController,$processDataForService);

try{
    $router->resolveAction();

}catch(Exception $e){
    echo json_encode([$e->getCode() => $e->getMessage()]);
    http_response_code($e->getCode());
}
header('Content-Type: application/json');