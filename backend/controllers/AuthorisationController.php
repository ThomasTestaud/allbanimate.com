<?php

namespace Controllers;

require_once 'vendor/autoload.php'; // Assuming you have the necessary JWT library installed

use \Firebase\JWT\JWT;


class AuthorisationController
{
    private $secretKey = 'eB38DDs7KKwP5532szZeZsZzeCCs'; // Replace with your own secret key


    public function connectUser($username, $password, $userId)
    {
        $payload = array(
            'username' => $username,
            'password' => $password,
            'userId' => $userId
        );

        $token = JWT::encode($payload, $this->secretKey); // Encode the payload into a JWT token
        $userId = JWT::encode($userId, $this->secretKey);

        // Return the token in JSON format
        header('Content-Type: application/json');
        echo json_encode(array('token' => $token, 'auth' => true));
        exit;
    }

    public function authenticate()
    {
        $token = $this->getTokenFromRequest(); // Get the token from the request

        if ($token) {
            try {
                // Verify and decode the token using the secret key
                $decoded = JWT::decode($token, $this->secretKey, array('HS256'));

                // Proceed with the request handling
                return $decoded;
            } catch (Exception $e) {
                // Token verification failed
                header('HTTP/1.0 401 Unauthorized');
                echo json_encode(array('error' => 'Invalid token'));
                exit;
            }
        } else {
            // No token provided
            header('HTTP/1.0 401 Unauthorized');
            echo json_encode(array('error' => 'No token provided'));
            exit;
        }
    }

    private function getTokenFromRequest()
    {
        $headers = getallheaders(); // Get all request headers
        $authorizationHeader = isset($headers['Authorization']) ? $headers['Authorization'] : '';

        if (preg_match('/Bearer\s(\S+)/', $authorizationHeader, $matches)) {
            // Extract the token from the Authorization header
            return $matches[1];
        }

        return null;
    }
}
