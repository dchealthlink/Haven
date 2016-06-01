<?php
echo "<br>";
$url = "http://dhsdcasesbsoaappuat01.dhs.dc.gov:8001/soa-infra/services/POC/EnrollAppLocalHubVerificationCmpService/enrollapplocalhubverificationbpelprocess_client_ep?WSDL";
$client = new SoapClient($url);
$fcs = $client->__getFunctions();
print_r($fcs);
echo "<br><br>";
$res = $client->xxx(array('id' => '123456789', 'other' => 'whatever'));
/*
$res = $client->GetWeather(array('CityName' => 'Lagos', 'CountryName' => 'Nigeria'));
var_dump($res);
echo "<br><br>";
$xml = file_get_contents($res);

echo "<br><br>";
echo $xml;
echo "<br><br>";
// SimpleXML seems to have problems with the colon ":" in the <xxx:yyy> response tags, so take them out
 $xml = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $xml);
 $xml = simplexml_load_string($xml);
 $json = json_encode($xml);
 $responseArray = json_decode($json,true);


echo "<br><br>";

# SoapClient_XSD_ANYXML.php
# Copyright (c) 2009 by Dr. Herong Yang, herongyang.com
# All rights reserved

#- Loading the WSDL document
   $server = "http://www.herongyang.com/Service/";
   $wsdl = $server . "Hello_WSDL_11_SOAP.wsdl";
   $client = new SoapClient($wsdl,
      array('trace' => TRUE));

#- Test 1: Calling with a string directly
   $input = "Hello as a string";
   $result = $client->Hello($input);
   print $client->__getLastRequest()."<br>";

#- Test 2: Calling with a SoapParam object
   $input = new SoapParam("Hello as a SoapParam object", "SoapParam");
   $result = $client->Hello($input);
   print $client->__getLastRequest()."<br>";

#- Test 3: Calling with a XSD_ANYXML SoapVar object
   $input = new SoapVar(
     "<SoapVar>Hello as an XSD_ANYXML SoapVar object</SoapVar>",
     XSD_ANYXML);
   $result = $client->Hello($input);
   print $client->__getLastRequest()."<br>";
*/
?>

