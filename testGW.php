<?php

class GetWeather{
var $CityName;//string
var $CountryName;//string
}
class GetWeatherResponse{
var $GetWeatherResult;//string
}
class GetCitiesByCountry{
var $CountryName;//string
}
class GetCitiesByCountryResponse{
var $GetCitiesByCountryResult;//string
}
class  
 {
 var $soapClient;
 
private static $classmap = array('GetWeather'=>'GetWeather'
,'GetWeatherResponse'=>'GetWeatherResponse'
,'GetCitiesByCountry'=>'GetCitiesByCountry'
,'GetCitiesByCountryResponse'=>'GetCitiesByCountryResponse'

);

 function __construct($url='http://www.webservicex.com/globalweather.asmx?wsdl')
 {
  $this->soapClient = new SoapClient($url,array("classmap"=>self::$classmap,"trace" => true,"exceptions" => true));
 }
 
function GetWeather($GetWeather)
{

$GetWeatherResponse = $this->soapClient->GetWeather($GetWeather);
return $GetWeatherResponse;

}
function GetCitiesByCountry($GetCitiesByCountry)
{

$GetCitiesByCountryResponse = $this->soapClient->GetCitiesByCountry($GetCitiesByCountry);
return $GetCitiesByCountryResponse;

}
function GetWeather($GetWeather)
{

$GetWeatherResponse = $this->soapClient->GetWeather($GetWeather);
return $GetWeatherResponse;

}
function GetCitiesByCountry($GetCitiesByCountry)
{

$GetCitiesByCountryResponse = $this->soapClient->GetCitiesByCountry($GetCitiesByCountry);
return $GetCitiesByCountryResponse;

}}


?>
