<?php
echo "pre SoapClient ";
//Create the client object
/* $soapclient = new SoapClient('http://www.webservicex.net/globalweather.asmx?WSDL');  */
$soapclient = new SoapClient('http://173.201.44.188/globalweather.asmx?WSDL');  
echo "post SoapClient ";
if ($soapclient) {



//Use the functions of the client, the params of the function are in
//the associative array
//$params = array('CountryName' => 'Sweden', 'CityName' => 'Stockholm');
echo $soapclient."<br>";
//$fcs = $soapclient->__getFunctions(); 
} else {
 $fcs = 'no dice';
}
print_r($fcs);
echo "<br><br>";

