<?php

namespace Controllers;

class UsersController
{

    public function connectUser()
    {
        $graphId = 80;

        $requestBody = array(
            'graphId' => $graphId
        );

        $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VybmFtZSI6IlRvdG8iLCJwYXNzd29yZCI6InBhc3N3b3JkIiwidXNlcklkIjp7ImlkIjoxfX0.JhyArjCDVP1eyygBrGjIYYe_mMECJcpVRvCG7BIUh_c";
        $headers = array(
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json'
        );

        $url = 'https://api-events-on-time.thomastestaud.com/index.php?route=event';

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestBody));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);

        curl_close($ch);
        




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
        $email = $data['email'];
        $userPassword = $data['userPassword'];

        $hashedPassword = password_hash($userPassword, PASSWORD_DEFAULT);

        // Check if username don't already exists
        $model = new \Models\Users();
        $usernameExist = $model->usernameExist($userName);
        $emailExist = $model->emailExist($email);

        if (!$usernameExist && !$emailExist) { // If the DDB returns nothing (false)

            $result = $model->createUser($userName, $email, $hashedPassword); // Create the account

            $result = ['id' => $result]; // Format same as other methods

            $authController = new \Controllers\AuthorisationController();
            $authController->connectUser($userName, $userPassword, $result);
        } else {
            header('Content-Type: application/json');
            echo json_encode(array('auth' => false, 'variables' => [
                'usernameExist' => $usernameExist,
                'emailExist' => $emailExist
            ]));
            exit;
        }
    }
}
