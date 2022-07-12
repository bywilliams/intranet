

<?php 

$config_user = $_SERVER["HTTP_USER_AGENT"];

//Google news API
$url = 'https://api.hgbrasil.com/finance?format=json-&key=f43b37b9';

// INICIALIZANDO O CURL
$ch = curl_init($url);

curl_setopt($ch, CURLOPT_USERAGENT, $config_user);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_REFERER, $url);

$newsData = json_decode(curl_exec($ch));
curl_close($ch);

$dollar = $newsData->results->currencies->USD->buy;
$euro = $newsData->results->currencies->EUR->buy;

//echo $dollar_final;
//echo $dollar;
// echo $euro."<br>";

?>