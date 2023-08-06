<?php

namespace Models;


class Events extends Database
{
    // GET
    public function getAllEventsFromGraph($userId, $graphId)
    {
        $req = "SELECT Events.name, x_value, y_value, Graphs.name as graphName, Graphs.type as graphType
                FROM `Events` 
                INNER JOIN `Graphs`
                ON Events.graph_id = Graphs.id
                WHERE Events.graph_id = :graphId AND Graphs.user_id = :userId";

        $params = [
            "userId" => $userId,
            "graphId" => $graphId
        ];

        $query = $this->bdd->prepare($req);
        $query->execute($params);
        return $query->fetchAll();
    }

    // POST
    public function postNewEvent($graphId, $x_value, $y_value)
    {
        $req = "INSERT INTO `Events`(`graph_id`, `x_value`, `y_value`) 
                VALUES (:graphId, :x_value , :y_value)";

        $params = [
            "graphId" => $graphId,
            "x_value" => $x_value,
            "y_value" => $y_value,
        ];

        $query = $this->bdd->prepare($req);
        $query->execute($params);
    }

    // DELETE
    public function deleteLastEvent($userId, $graphId)
    {
        $req = "DELETE FROM `Events` INNER JOIN Graphs ON graph_id = Graphs.id WHERE graph_id = :graphId AND Graphs.user_id = :userId ORDER BY Events.id DESC LIMIT 1";

        $params = [
            "userId" => $userId,
            "graphId" => $graphId
        ];

        $query = $this->bdd->prepare($req);
        $query->execute($params);
    }
}
