<?php
echo "<br>";
echo "pre sc ";
$url = "http://dhsdcasesbsoaappuat01.dhs.dc.gov:8001/soa-infra/services/POC/EnrollAppLocalHubVerificationCmpService/enrollapplocalhubverificationbpelprocess_client_ep?WSDL=RuntimeFault.wsdl?WSDL";
$url = "http://dhsdcasesbsoajmydev01.dhs.dc.gov:8001/soa-infra/services/EnrollApp/EnrollAppRIDPFedSvc/enrollappridpfedsvc_client_ep?WSDL";
// $url = "http://www.webservicex.net/globalweather.asmx?WSDL";
$url = "http://dhsdcasesbsoaappuat01.dhs.dc.gov:8001/soa-infra/services/POC/EnrollAppLocalHubVerificationCmpService/enrollapplocalhubverificationbpelprocess_client_ep?WSDL";
$client = new SoapClient($url, array('trace' => 1) );
echo "post sc ";
$fcs = $client->__getFunctions();
print_r($fcs);
echo "<br><br>";
foreach ($fcs as $k => $v) {
    echo "[$k] => $v.<br>";
}

echo "<br><br>";


   $input = new SoapVar(
    "<individual>
            <id>
               <id>1234</id>
            </id>
            <person>
               <id>
                  <id>1234</id>
               </person>
               <person_name>
                  <person_surname>Edward</person_surname>
                  <person_given_name>Ann</person_given_name>
               </person_name>
         </individual>", 
     XSD_ANYXML);


$params = array('id' => '1234', 'person_surname' => 'Edward', 'person_given_name' => 'Ann');
$result = $client->process($params);

   print "REQUEST:\n".$client->__getLastRequestHeaders()."\n";
var_dump($result);

