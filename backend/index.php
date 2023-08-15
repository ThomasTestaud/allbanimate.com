<?php

spl_autoload_register(function ($class) {
    require_once lcfirst(str_replace('\\', '/', $class)) . '.php';
});

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

$authController = new Controllers\AuthorisationController();

//ROUTER
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // This is a preflight request
    header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
exit;

} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {

    switch ($_GET['route']) {

        case 'create-project':
            $decoded = $authController->authenticate(); // Authenticate the user before processing the request
            $userId = $decoded->userId->id; // Extract userId

            $controller = new Controllers\ProjectsController();
            $controller->createNewProject($userId);
        break;

        case 'connect':
            $controller = new Controllers\UsersController();
            $controller->connectUser();
        break;

        case 'user':
            $controller = new Controllers\UsersController();
            $controller->createUser();
        break;

        case 'download-project':
            $decoded = $authController->authenticate(); // Authenticate the user before processing the request
            $userId = $decoded->userId->id; // Extract userId

            $controller = new Controllers\ConverterController();
            $controller->covertToMP4($userId);
        break;
    }

} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {

    switch ($_GET['route']) {

        case 'project-list':
            $decoded = $authController->authenticate(); // Authenticate the user before processing the request
            $userId = $decoded->userId->id; // Extract userId

            $controller = new Controllers\ProjectsController();
            $controller->getAllProjectsFromUser($userId);
        break;

        case 'project':
            $decoded = $authController->authenticate(); // Authenticate the user before processing the request
            $userId = $decoded->userId->id; // Extract userId

            $controller = new Controllers\ProjectsController();
            $result = $controller->getProjectsFromNameAndUser($userId);
        break;
    }
    
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {

    switch ($_GET['route']) {

        case 'save-project':
            $decoded = $authController->authenticate(); // Authenticate the user before processing the request
            $userId = $decoded->userId->id; // Extract userId

            $controller = new Controllers\ProjectsController();
            $controller->saveProject($userId);
        break;

    }

} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {

    switch ($_GET['route']) {

        case 'project':
            //$decoded = $authController->authenticate(); // Authenticate the user before processing the request
            //$userId = $decoded->userId->id; // Extract userId

            //$controller = new Controllers\EventsController();
            //$controller->deleteLastEvent($userId);
        break;
    }

}  else {

    $json = json_encode('else   ');
    echo ($json);
}
