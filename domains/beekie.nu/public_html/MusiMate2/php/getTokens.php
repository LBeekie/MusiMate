<?php
$client_id = '02cbda7672eb460d999e50b2b3d20b78';
$client_secret = '9aea7a1cd16442d5b7ffa4c8f7fc3027';

$authToken = $_GET['authToken'];
$redirect_uri = $_GET['redirect_uri'];

$authorization = base64_encode($client_id . ":" . $client_secret);

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://accounts.spotify.com/api/token');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=authorization_code&code=". $authToken ."&redirect_uri=" . $redirect_uri);
curl_setopt($ch, CURLOPT_POST, 1);

$headers = array();
$headers[] = 'Authorization: Basic ' . $authorization;
$headers[] = 'Content-Type: application/x-www-form-urlencoded';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}

echo $result;

curl_close ($ch);
?>