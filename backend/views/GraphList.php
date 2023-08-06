<?php

namespace views;


class GraphList
{
    public function prepareDataForOutput($data)
    {
        $newData = [];

        foreach ($data as $element) {
            $newData[] = [
                'name' => htmlspecialchars($element['name']), // Sanitize the name
                'id' => $element['id'],
                'events' => $element['events'],
                'first_event' => $element['first_event'],
                'last_event' => $element['last_event'],
            ];
        }

        return $newData;
    }
}
