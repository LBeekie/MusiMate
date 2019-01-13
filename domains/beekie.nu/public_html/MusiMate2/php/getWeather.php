<?php
//Get current weather and put into json
// Get cURL resource
$curl = curl_init();
// Set some options - we are passing in a useragent too here
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://dataservice.accuweather.com/forecasts/v1/daily/1day/249208?apikey=S2VG0mPbieF3GB1Acra0NZPvOhAPPhEZ&details=true&metric=true',
    CURLOPT_USERAGENT => 'MusiMate get current conditions'
));
// Send the request & save response to $resp
$resp = curl_exec($curl);
//echo $resp;

$fp = fopen('../json/weatherAll.json', 'w');
fwrite($fp, $resp);
fclose($fp);

// Close request to clear up some resources
curl_close($curl);
?>