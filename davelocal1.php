<?php 
// below $option=array('trace',1); 
// correct one is below 
$option=array('trace'=>1); 

$client=new SoapClient('http://www.webservicex.net/globalweather.asmx?WSDL',$option); 

try{ 
  $client->__getFunctions(); 
}catch(SoapFault $fault){ 
  // <xmp> tag displays xml output in html 
  print 'Request : <br/><xmp>'. 
  $client->__getLastRequestHeaders(). 
  '</xmp><br/><br/> Error Message : <br/>'. 
  $fault->getMessage(); 
} 
?> 
