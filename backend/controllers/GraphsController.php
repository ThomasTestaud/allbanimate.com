<?php

namespace Controllers;


class GraphsController
{
    public function getAllGraphsFromUser($userId)
    {
        $model = new \Models\Graphs();
        $data = $model->getAllGraphsFromUser($userId);

        $view = new \Views\GraphList();
        $data = $view->prepareDataForOutput($data);

        $json = json_encode($data);
        echo ($json);
        exit;
    }

    public function createNewGraph($userId)
    {
        $content = file_get_contents("php://input");
        $data = json_decode($content, true);

        $graphName = $data['graphName'];

        $model = new \Models\Graphs();
        $result = $model->createNewGraph($userId, $graphName);

        echo $result; // Send back the ID of the created list
        exit;
    }

    public function deleteGraph($userId)
    {
        $model = new \Models\Graphs();
        $model->deleteGraph($userId, $_GET['graphId']);
    }
}
