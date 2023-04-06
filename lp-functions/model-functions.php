<?php

/**
 * Helper Funktion für das Auslesen von JSON-Files
 * @param $path ist der Pfad des JSON-Files
 * 
 */
function getFromJson($path){
    $jsonString = file_get_contents($path);
        if ($jsonString === false) {
            return null;
        }
        $jsonObjects = json_decode($jsonString);
        return $jsonObjects;
}