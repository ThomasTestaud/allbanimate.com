<?php

namespace Controllers;

class EventsController
{

    public function getEvents($userId, $graphId)
    {
        $model = new \Models\Events();
        $result = $model->getAllEventsFromGraph($userId, $graphId);

        $view = new \Views\Graph();
        $data = $view->prepareDataForOutput($result);

        $json = json_encode($data);
        echo ($json);
        exit;
    }

    public function postNewEvent($userId)
    {
        $content = file_get_contents("php://input");
        $data = json_decode($content, true);

        $graphId = $data['graphId'];
        $x_value = time(); // Create the timestemp of the event
        $y_value = 1;

        $model = new \Models\Events();
        $model->postNewEvent($graphId, $x_value, $y_value);

        $this->getEvents($userId, $graphId);
    }

    public function deleteLastEvent($userId)
    {
        $model = new \Models\Events();
        return $model->deleteLastEvent($userId, $_GET['graphId']);
    }
}
