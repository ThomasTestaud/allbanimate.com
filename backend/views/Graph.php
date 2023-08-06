<?php

namespace views;


class Graph
{

    public function prepareDataForOutput($data)
    {
        $newData = [];

        foreach ($data as $element) {
            $newData[] = [
                'graphName' => htmlspecialchars($element['graphName']), // Sanitize the name
                'x_value' => $element['x_value'],
                'y_value' => $element['y_value'],
            ];
        }

        return $newData;
    }

    /*
    public function prepareDataForOutput($data)
    {
        if (count($data) > 0) {
            $graphData = [
                'graphName' => htmlspecialchars($data[0]['graphName'])
            ];
        } else {
            $graphData = [
                'graphName' => 'No data yet...'
            ];
        }

        $eventsArrays = $this->outPutInOneArray($data); //Sort and sanitize the data

        //$eventsArrays = $this->splitEventsByName($data);  //Sort and sanitize the data

        return $newData = [
            'graphData' => $graphData,
            'eventsArrays' => $eventsArrays
        ];
    }*/

    private function splitEventsByName($array) // take one array, return a nested array with as many arrays as there is differents Events.name
    {
        $result = array();

        foreach ($array as $event) {
            $name = $event['name'];

            if (!isset($result[$name])) {
                $result[$name] = array();
            }

            $result[$name][] = [
                'x_value' => $event['x_value'],
                'y_value' => $event['y_value']
            ];
        }

        return $result;
    }

    private function outPutInOneArray($array)
    {
        $eventsArrays = [];

        foreach ($array as $element) {
            $eventsArrays[] = [
                'event_name' => htmlspecialchars($element['name']), // Sanitize the name
                'x_value' => $element['x_value'],
                'y_value' => $element['y_value'],
            ];
        };

        return $eventsArrays;
    }
}
