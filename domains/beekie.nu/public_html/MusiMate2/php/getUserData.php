<?php
$accessToken = $_GET['accessToken'];

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api.spotify.com/v1/me');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


$headers = array();
$headers[] = 'Authorization: Bearer '. $accessToken;
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}

echo $result;

curl_close ($ch);
?>