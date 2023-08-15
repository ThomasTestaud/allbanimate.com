<?php

namespace Controllers;


class ProjectsController
{
    public function createNewProject($userId)
    {
        $content = file_get_contents("php://input");
        $data = json_decode($content, true);

        $projectName = $data['graphName'];

        $projectName = str_replace(' ', '_', $projectName);

        $projectDefaultData = '{
          "calkLayers": [
            {
              "code": ["", "", "", ""],
              "displayed": true,
              "onion": true,
              "name": "Layer 1"
            },
            {
              "code": ["", "", "", ""],
              "displayed": true,
              "onion": true,
              "name": "Layer 2"
            }
          ],
          "calkLayersEverCount": 2,
          "frameRate": 6,
          "drawingToolsData": {
            "currentTool": false,
            "currentColor": false,
            "currentSize": 10,
            "currentOpacity": 100,
            "currentParticleSize": 3,
            "currentDensity": 40,
            "currentRGB": [0, 0, 0]
          },
          "memoryColorPalette": [
            { "string": "white", "rgb": [255, 255, 255] },
            { "string": "black", "rgb": [0, 0, 0] }
          ],
          "displayedFrame": 0,
          "selectedCalk": 0,
          "lineWidth": 10,
          "onionValue": [1, 5, 10, 100, 10, 5, 1],
          "onionLayerState": [false, true, true, true, false, false, false]
        }';

          $projectDefaultData = preg_replace('/[ \t\n\r\v\f\\\\]/', '', $projectDefaultData);

        $model = new \Models\Projects();
        $result = $model->createNewProject($userId, $projectName, $projectDefaultData);

        echo $projectName; // Send back the ID of the created list
        exit;
    }

    public function getAllProjectsFromUser($userId)
    {
        $model = new \Models\Projects();
        $data = $model->getAllProjectsFromUser($userId);

        //$view = new \Views\GraphList();
        //$data = $view->prepareDataForOutput($data);

        $json = json_encode($data);
        echo ($json);
        exit;
    }

    public function getProjectsFromNameAndUser($userId)
    {
        $projectName =  $_GET['projectName'];

        $model = new \Models\Projects();
        $data = $model->getProjectsFromNameAndUser($userId, $projectName);

        //$view = new \Views\GraphList();
        //$data = $view->prepareDataForOutput($data);

        $json = json_encode($data);
        echo ($json);
        exit;
    }

    public function saveProject($userId)
    {
        $content = file_get_contents("php://input");
        $data = json_decode($content, true);

        $projectName = $data['projectName'];
        $projectName = str_replace(' ', '_', $projectName);

        $projectData = json_encode($data['projectData']);
        
        $model = new \Models\Projects();
        $model->saveProject($userId, $projectName, $projectData);
        
        echo ("I guess save worked... ");
        echo (strlen($projectData));
        exit;
    }
}
