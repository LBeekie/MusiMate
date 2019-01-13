<?php
// Read JSON file
$json = file_get_contents('../json/weatherAll.json');

//Decode JSON
$json = json_decode($json,true);

//print_r($json);
$calc = [];
$weather = [];
//Print data
$weather[0] = $json[DailyForecasts][0][Date];
$weather[1] = $json[DailyForecasts][0][Day][Icon];

//Define weather type based on icon number
$cloudy = array(6, 7, 8, 11, 24);
$rain = array(12, 13, 14, 15, 16, 17, 18, 25, 26, 29);
$snow = array(19, 20, 21, 22, 23);
$sunny = array(1, 2, 3, 4, 5);

if(in_array($weather[1], $cloudy)) {
    $weather[2] = "Cloudy";
    $calc[0] = 0.216;
    $calc[1] = 0.478;
    $calc[2] = 0.605;
    $calc[3] = 0.392;
    $calc[4] = 0.392;
    $calc[5] = 0.381;
    $genre = "chill,hip-hop,rock";
} elseif(in_array($weather[1], $rain)) {
    $weather[2] = "Rain";
    $calc[0] = 0.212;
    $calc[1] = 0.489;
    $calc[2] = 0.598;
    $calc[3] = 0.385;
    $calc[4] = 0.397;
    $calc[5] = 0.381;
    $genre = "chill,rainy-day,hardstyle";
} elseif(in_array($weather[1], $snow)) {
    $weather[2] = "Snow";
    $calc[0] = 0.196;
    $calc[1] = 0.525;
    $calc[2] = 0.734;
    $calc[3] = 0.343;
    $calc[4] = 0.475;
    $calc[5] = 0.406;
    $genre = "chill,pop,happy";
} elseif(in_array($weather[1], $sunny)) {
    $weather[2] = "Sunny";
    $calc[0] = 0.238;
    $calc[1] = 0.629;
    $calc[2] = 0.950;
    $calc[3] = 0.263;
    $calc[4] = 0.706;
    $calc[5] = 0.496;
    $genre = "hardstyle,dance,summer";
}



$jsonWrite = '{"Date": "'. $weather[0] .'", "Icon": '. $weather[1] .', "Type": "'. $weather[2] .'", "Accousticness": '. $calc[0] .', "Danceability": '. $calc[1] .', "Energy": '. $calc[2] .', "Organism": '. $calc[3] .', "Valence": '. $calc[4] .', "Bounciness": '. $calc[5] .', "Genre": "'. $genre .'"}';

echo json_encode($jsonWrite);

$fp = fopen('../json/weather.json', 'w');
fwrite($fp, $jsonWrite);
fclose($fp);
?>