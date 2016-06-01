<?php

// set HTTP header
$headers = array(
    'Content-Type: application/json'
);

// set POST params
$fields = array(
    'user' => '2',
    'num' => '3',
    'format' => 'json',
);
$data="user=2&num=3&format=json";
$url = 'http://cubs.igniteservice.net/web-serv.php';

// Open connection
 $ch = curl_init();

// Set the url, number of POST vars, POST data
// echo $url."<br><br>" ;
 curl_setopt($ch, CURLOPT_URL, $url);
 curl_setopt($ch, CURLOPT_POST, true);
// curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );

// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
 curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
// curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
// curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

// Execute post

$result = curl_exec($ch);

// Close connection
curl_close($ch);

print_r( $result)."<br><br>";

$result_arr = json_decode($result, true);
print_r($result_arr);
?>

