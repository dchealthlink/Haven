<?php
//Create the client object
$soapclient = new SoapClient('http://www.webservicex.net/globalweather.asmx?WSDL');

//Use the functions of the client, the params of the function are in
//the associative array
//$params = array('CountryName' => 'Sweden', 'CityName' => 'Stockholm');


$fcs = $soapclient->__getFunctions();
print_r($fcs);
echo "<br><br>";
foreach ($fcs as $k => $v) {
    echo "[$k] => $v.<br>";
}

echo "<br><br>";
$params = array('CountryName' => $_GET['co']);
// $response = $client->GetWeather(array('CityName' => 'Lagos', 'CountryName' => 'Nigeria'));

// $response = $soapclient->getWeather($params);

$obj = $soapclient->GetCitiesByCountry($params);

$outfile = fopen("/tmp/dummy_obj.xml","w") ;
$putline = $obj->GetCitiesByCountryResult;
print_r($putline);
fputs ($outfile, $putline);
fputs ($outfile, "\n");
fclose ($outfile);

/*
$stringput = '<<< XML '.$putline.' XML;';
$newxml = simplexml_load_string($stringput);
echo 'new xml ==> ';
print_r($newxml) ;
echo $stringput;
echo "<br><br>";
*/

//echo "<br><br>";
$nolines =  shell_exec('wc -l /tmp/dummy_obj.xml');
$nl = explode(" ",$nolines);
exec('tail -n '.($nl[0] - 1).' /tmp/dummy_obj.xml > /tmp/dummy_obj2.xml');

if (file_exists('/tmp/dummy_obj2.xml')) {
    $xml = simplexml_load_file('/tmp/dummy_obj2.xml');

//    print_r($xml);
//echo "<br><br>";
// print_r(get_object_vars($xml));
//echo "<br><br>";
foreach ($xml as $k => $v) {
    echo "[$k] => $v.<br>";
}


echo "<br><br>";
} else {
    exit('Failed to open dummy_obj.xml.');
}
/*
echo "<br><br>";

echo "reg resp === > ";
var_dump($response);
echo "<br><br>";

echo "is it object? ".(is_object($response))."<br><br>";
$response = get_object_vars($response);
var_dump($response);
echo "<br><br>";


echo "is it array? ".(is_array($response))."<br><br>";
$whatev = array_values($response);
var_dump($whatev);
echo "<br><br>";
echo "is it array? ".(is_array($whatev))."<br><br>";
$whatev1 = array_values($whatev);
var_dump($whatev1);
echo "<br><br>";




$simple = $whatev;
*/
/*
$simple = "<CurrentWeather>
<Location>Alicante / El Altet, Spain (LEAL) 38-17N 000-33W 31M</Location>
  <Time>Aug 16, 2015 - 03:00 PM EDT / 2015.08.16 1900 UTC</Time>
  <Wind> from the S (170 degrees) at 3 MPH (3 KT) (direction variable):0</Wind>
  <Visibility> greater than 7 mile(s):0</Visibility>
  <SkyConditions> mostly clear</SkyConditions>
  <Temperature> 80 F (27 C)</Temperature>
  <DewPoint> 69 F (21 C)</DewPoint>
  <RelativeHumidity> 69%</RelativeHumidity>
  <Pressure> 29.88 in. Hg (1012 hPa)</Pressure>
  <Status>Success</Status>
</CurrentWeather>
";
*/

/*
$p = xml_parser_create();
xml_parse_into_struct($p, $simple, $vals, $index);
xml_parser_free($p);

echo "Index array\n";
print_r($index);
echo "<br><br>";

echo "\nVals array\n";
print_r($vals);
*/
?>
