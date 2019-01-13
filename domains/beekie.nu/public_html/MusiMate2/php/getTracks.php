<?php
$accToken = $_GET['accessToken'];

$json = file_get_contents('../json/weather.json');

//Decode JSON
$json = json_decode($json,true);

//print_r($json);

$target = [];
$target[0] = $json[Accousticness];
$target[1] = $json[Danceability];
$target[2] = $json[Energy];
$target[3] = $json[Organism];
$target[4] = $json[Valence];
$target[5] = $json[Bounciness];
$target[6] = $json[Genre];

$ch = curl_init();

$param = '?limit=100&market=NL&seed_genres='. $target[6] .'&target_accousticness='. $target[0] .'&target_danceability='. $target[1] .'&target_energy='. $target[2] .'&target_instrumentalness='. $target[3] .'&target_valence='. $target[5] .'&min_popularity=30';

echo $param;

curl_setopt($ch, CURLOPT_URL, 'https://api.spotify.com/v1/recommendations' . $param);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


$headers = array();
$headers[] = 'Authorization: Bearer '. $accToken;
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close ($ch);

$fp = fopen('../json/playlist.json', 'w');
fwrite($fp, $result);
fclose($fp);
?>