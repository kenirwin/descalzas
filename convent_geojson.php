<?php
require ("JsonToGeoJson.class.php");
$url = "http://www.wittprojects.net/dev/agb/convents.json";
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HEADER, 0); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$json = curl_exec ($ch);
$file = new JsonToGeoJson($json, "convents");
$file->transform();
print $file->geojson;
?>