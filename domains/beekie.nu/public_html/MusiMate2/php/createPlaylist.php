<?php
$userId = $_GET['userId'];
$accToken = $_GET['accToken'];
//echo $userId;
$date = date("d/m/Y");

//Create playlist
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api.spotify.com/v1/users/'. $userId .'/playlists');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"name\":\"". $date ."\", \"public\":false}");
curl_setopt($ch, CURLOPT_POST, 1);

$headers = array();
$headers[] = 'Authorization: Bearer ' . $accToken;
$headers[] = 'Content-Type: application/json';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}

curl_close ($ch);

echo $result;
?>