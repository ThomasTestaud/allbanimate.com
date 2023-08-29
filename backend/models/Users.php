<?php

namespace Models;


class Users extends Database
{
    public function connectUser($userName) //Return userId and hashedPassword
    {
        $req = "SELECT id as userId, password as hashedPassword FROM `users` WHERE username = :userName OR email = :userName";

        $params = [
            "userName" => $userName
        ];

        $query = $this->bdd->prepare($req);
        $query->execute($params);
        return $query->fetch();
    }

    public function createUser($userName, $email, $userPassword)
    {
        $req = "INSERT INTO `users`(`username`, `password`, `email`) 
                VALUES ( :userName, :userPassword, :email)";

        $params = [
            "userName" => $userName,
            "email" => $email,
            "userPassword" => $userPassword
        ];

        $query = $this->bdd->prepare($req);
        $query->execute($params);

        // Retrieve the ID of the newly created line
        $lastInsertedId = $this->bdd->lastInsertId();

        return $lastInsertedId;
    }

    public function usernameExist($userName)
    {
        $req = "SELECT username FROM `users` WHERE username = :userName";

        $params = [
            "userName" => $userName
        ];

        $query = $this->bdd->prepare($req);
        $query->execute($params);
        return $query->fetch();
    }

    public function emailExist($email)
    {
        $req = "SELECT email FROM `users` WHERE email = :email";

        $params = [
            "email" => $email
        ];

        $query = $this->bdd->prepare($req);
        $query->execute($params);
        return $query->fetch();
    }
}
