<?php

// set HTTP header
$headers = array(
    'Content-Type: application/json',
);

// query string
$fields = array(
    'user' => '2',
    'num' => '4',
    'format' => 'json',
);
$url = 'http://cubs.igniteservice.net/web-service.php?' . http_build_query($fields);
echo $url."<br><br>";

// Open connection
$ch = curl_init();

// Set the url, number of GET vars, GET data
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, false);
// curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );

curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

// Execute request
$result = curl_exec($ch);
echo $result."<br><br>";

// Close connection
curl_close($ch);

// get the result and parse to JSON
$result_arr = json_decode($result, true);

print_r($result_arr);
/*
 *  output:
 *  Array
 *  (
 *      [statusCode] => "OK",
 *      [statusMessage] => "",
 *      [ipAddress] => "123.13.123.12",
 *      [countryCode] => "MY",
 *      [countryName] => "MALAYSIA",
 *  )
 */
 ?>

