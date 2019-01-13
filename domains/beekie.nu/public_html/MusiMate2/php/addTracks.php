<?php
$playlistId = $_GET['playlistId'];
$accToken = $_GET['accToken'];

// Read JSON file
$jsonRaw = file_get_contents('../json/playlist.json');
//Decode JSON
$jsonF = json_decode($jsonRaw,false);
$jsonT = json_decode($jsonRaw,true);
//Get amount of tracks
$amount = count($jsonT['tracks']) -1;
//Create array of tracks
$uris = array();
for ($x = 0; $x <= $amount; $x++) {
    $uris->uris = array_push($uris, $jsonF->tracks[$x]->uri);
} 
$urisJson = json_encode($uris);
//Create json format
$urisJson = '{"uris":'.$urisJson.'}';
echo $urisJson;
//Add tracks to playlist
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api.spotify.com/v1/playlists/'. $playlistId .'/tracks');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $urisJson);

$headers = array();
$headers[] = 'Authorization: Bearer '. $accToken;
$headers[] = 'Accept: application/json';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close ($ch);
?>