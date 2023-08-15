<?php

namespace Controllers;

require('config/config.php');

class ConverterController
{
    public function createFolderArea($userId)
    {
        $directory = "src/convert_area/" . $userId;

        // Create a folder for that user if it does not already exist
        if (!file_exists($directory)) {
            if (mkdir($directory, 0777, true)) {
                echo "Folder created successfully.";
            } else {
                echo "Failed to create folder.";
            }
        } else {
            echo "Folder already exists.";
        }
    }

    public function addPhotoToFolder($userId)
    {   
        $directory = "src/convert_area/" . $userId;

        
    }

    public function covertToMP4($userId)
    {
        $content = file_get_contents("php://input");
        $data = json_decode($content, true);
        
        $videoTitle = $data['projectName'];
        $targetFormat = $data['targetFormat'];
        $framerate = 6;
        $frameLength = 100;
        $frameDuration = $framerate * $frameLength;

        $imagesPath = 'src/convert_area/'.$userId."/";
        
        // Build the ffmpeg command
        if($targetFormat === 'mp4') {

            $outputVideo = $imagesPath . $videoTitle . ".mp4";
    
            if (file_exists($outputVideo)) {
                unlink($outputVideo);
            }

            $ffmpegCommand = "ffmpeg -framerate 3 -pattern_type glob -i '$imagesPath/*.png' -vf 'fps=25' -c:v libx264 -pix_fmt yuv420p -t $frameDuration $outputVideo";

        } else if($targetFormat === 'gif') {

            $outputVideo = $imagesPath . $videoTitle . ".gif";
    
            if (file_exists($outputVideo)) {
                unlink($outputVideo);
            }

            $ffmpegCommand = "ffmpeg -framerate 3 -pattern_type glob -i '$imagesPath/*.png' -vf 'fps=25,scale=trunc(iw/2)*2:trunc(ih/2)*2' -c:v gif $outputVideo";
        }

        // Execute the ffmpeg command
        exec($ffmpegCommand, $output, $returnCode);

        if ($returnCode === 0) {

            $downloadLink = DOMAIN_LINK . $outputVideo;
            //echo $targetFormat;
            echo $downloadLink;

        } else {
            $response['status'] = "error";
            $response['message'] = "Video creation failed. Error code: $returnCode";
            $response['output'] = $output;
            $response['data'] = $imagesPath;

            $responseJSON = json_encode($response);
            echo $responseJSON;
        }
    }

}
