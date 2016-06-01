<?php
// Get cURL resource
$curl = curl_init();
// Set some options - we are passing in a useragent too here
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://cubs.igniteservice.net/web-service.php',
    CURLOPT_USERAGENT => 'Codular Sample cURL Request',
    CURLOPT_POST => 1,
    CURLOPT_POSTFIELDS => array(
        user => '2',
        num => '3',
        format => 'xml'
    )
));
// Send the request & save response to $resp
$resp = curl_exec($curl);
// Close request to clear up some resources
curl_close($curl);
echo $resp."<br><br>";
print_r($resp);
?>
