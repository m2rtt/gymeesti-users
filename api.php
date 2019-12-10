<?php

$type = $_REQUEST["type"];
$token = $_REQUEST["token"];

$curl = curl_init();
if ($type == "users") {
  $clubId = $_REQUEST["clubId"];
  $url = "https://gymestonia.perfectgym.com/Api/Clubs/WhoIsIn?clubId=".$clubId;
} else if ($type == "gyms") {
  $url = "https://gymestonia.perfectgym.com/Api/Clubs/Clubs";
}
$header = array();
$header[] = 'Content-type: application/json';
$header[] ='Authorization: Bearer '.$token;
curl_setopt($curl, CURLOPT_HTTPHEADER, $header);

curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

$result = curl_exec($curl);

curl_close($curl);
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
echo $result;
?>