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

        case 'event':
            $decoded = $authController->authenticate(); // Authenticate the user before processing the request
            $userId = $decoded->userId->id; // Extract userId

            $controller = new Controllers\EventsController();
            $controller->postNewEvent($userId);
            break;

        case 'graph':
            $decoded = $authController->authenticate(); // Authenticate the user before processing the request
            $userId = $decoded->userId->id; // Extract userId

            $controller = new Controllers\GraphsController();
            $controller->createNewGraph($userId);
        break;

        case 'connect':
            $controller = new Controllers\UsersController();
            $controller->connectUser();
            break;

        case 'user':
            $controller = new Controllers\UsersController();
            $controller->createUser();
        break;
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {

    switch ($_GET['route']) {

        case 'list':
            $decoded = $authController->authenticate(); // Authenticate the user before processing the request

            $userId = $decoded->userId->id; // Extract userId

            $controller = new Controllers\GraphsController();
            $result = $controller->getAllGraphsFromUser($userId);
            break;

        case 'graph':
            $decoded = $authController->authenticate(); // Authenticate the user before processing the request
            $userId = $decoded->userId->id; // Extract userId

            $controller = new Controllers\EventsController();
            $result = $controller->getEvents($userId, $_GET['graphId']);
            break;
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {

    switch ($_GET['route']) {

        case 'event':
            $decoded = $authController->authenticate(); // Authenticate the user before processing the request
            $userId = $decoded->userId->id; // Extract userId

            $controller = new Controllers\EventsController();
            $controller->deleteLastEvent($userId);
            break;

        case 'graph':
            $decoded = $authController->authenticate(); // Authenticate the user before processing the request
            $userId = $decoded->userId->id; // Extract userId

            $controller = new Controllers\GraphsController();
            $controller->deleteGraph($userId);
            break;
    }
} else {

    $json = json_encode('else   ');
    echo ($json);
}
