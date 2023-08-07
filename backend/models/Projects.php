<?php

namespace Models;


class Projects extends Database
{

    public function createNewProject($userId, $projectName, $data)
    {
        $req = "INSERT INTO `projects`(`user_id`, `name`, `data`) 
                VALUES (:userId, :projectName, :projectData)";

        $params = [
            "userId" => $userId,
            "projectName" => $projectName,
            "projectData" => $data
        ];

        $query = $this->bdd->prepare($req);
        $query->execute($params);
        // Retrieve the ID of the newly created line
        $lastInsertedId = $this->bdd->lastInsertId();

        return $lastInsertedId;
    }

    public function getAllProjectsFromUser($userId)
    {
        $req = "SELECT `name`, `last_save` FROM `projects`
        WHERE user_id = :userId;";

        $params = [
            "userId" => $userId
        ];

        $query = $this->bdd->prepare($req);
        $query->execute($params);
        return $query->fetchAll();
    }

    public function getProjectsFromNameAndUser($userId, $projectName)
    {
        $req = "SELECT `data` FROM `projects`
        WHERE user_id = :userId AND name = :projectName;";

        $params = [
            "userId" => $userId,
            "projectName" => $projectName
        ];

        $query = $this->bdd->prepare($req);
        $query->execute($params);
        return $query->fetch();
    }
}
