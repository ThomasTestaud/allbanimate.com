<?php

namespace Controllers;

class UsersController
{

    public function connectUser()
    {
        $content = file_get_contents("php://input");
        $data = json_decode($content, true);

        $userName = $data['userName'];
        $clearPassword = $data['userPassword'];

        $model = new \Models\Users();
        $data = $model->connectUser($userName); //Return userId and hashedPassword

        $userId = $data['userId'];
        $hashedPassword = $data['hashedPassword'];

        if (password_verify($clearPassword, $hashedPassword)) {
            $validate = true;
        } else {
            $validate = false;
        }

        $userId = ['id' => $userId]; // Format same as other methods

        if (!$validate) {
            $json = json_encode($validate);
            echo ($json);
        } else {
            $authController = new \Controllers\AuthorisationController();
            $authController->connectUser($userName, $clearPassword, $userId);
        }
    }

    public function createUser()
    {
        // Retrive data
        $content = file_get_contents("php://input");
        $data = json_decode($content, true);

        $userName = $data['userName'];
        $userPassword = $data['userPassword'];

        $hashedPassword = password_hash($userPassword, PASSWORD_DEFAULT);

        // Check if username don't already exists
        $model = new \Models\Users();
        $result = $model->usernameExist($userName);

        if (!$result) { // If the DDB returns nothing (false)

            $result = $model->createUser($userName, $hashedPassword); // Create the account

            $result = ['id' => $result]; // Format same as other methods

            $authController = new \Controllers\AuthorisationController();
            $authController->connectUser($userName, $userPassword, $result);
        } else {
            header('Content-Type: application/json');
            echo json_encode(array('auth' => false));
            exit;
        }
    }
}
