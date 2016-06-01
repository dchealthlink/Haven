<?php
echo "<br>";
echo "pre sc ";
$url = "http://dhsdcasesbsoaappuat01.dhs.dc.gov:8001/soa-infra/services/POC/EnrollAppLocalHubVerificationCmpService/enrollapplocalhubverificationbpelprocess_client_ep?WSDL=RuntimeFault.wsdl?WSDL";
$url = "http://dhsdcasesbsoajmydev01.dhs.dc.gov:8001/soa-infra/services/EnrollApp/EnrollAppRIDPFedSvc/enrollappridpfedsvc_client_ep?WSDL";
// $url = "http://www.webservicex.net/globalweather.asmx?WSDL";
$url = "http://dhsdcasesbsoaappuat01.dhs.dc.gov:8001/soa-infra/services/POC/EnrollAppLocalHubVerificationCmpService/enrollapplocalhubverificationbpelprocess_client_ep?WSDL";
$url = "http://dhsdcasesbsoajmydev01.dhs.dc.gov:8001/soa-infra/services/EnrollApp/EnrollAppRIDPFedSvc/enrollappridpfedsvc_client_ep?WSDL";
$url = "http://10.82.54.209:8001/soa-infra/services/EnrollApp/EnrollAppLocalHubVerificationCmpService/enrollapplocalhubverificationbpelprocess_client_ep?WSDL";
$client = new SoapClient($url, array('trace' => 1) );
echo "post sc ";
$fcs = $client->__getFunctions();
print_r($fcs);
echo "<br><br>";
// var_dump($client->__getTypes());
// echo "<br><br>";
foreach ($fcs as $k => $v) {
    echo "[$k] => $v.<br>";
}

echo "<br><br>";

/*
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
*/

// $params = array('interactive_verification_start' => 'xmlns:xsi=\'http://www.w3.org/2001/XMLSchema-instance\' xmlns=\'http://openhbx.org/api/terms/1.0\'', 'individual' => array('id' => '1234', 'person' => array ('id' => '1234', 'person_name' => array('person_surname' => 'Edward', 'person_given_name' => 'Ann'), 'addresses' => array ('address' => array ('type' => 'urn:openhbx:terms:v1:address_type#mailing', 'address_line_1' => '87 Westerfield Plaza', 'location_city_name' => 'Seaside','location_state_code' => 'MD', 'postal_code' => '13455') ), 'phones' => array ('phone' => array ('type' => 'urn:openhbx:terms:v1:phone_type#mobile', 'full_phone_number' => '14016906878','is_preferred' => 'false') )  ) ) );

/* address not authed */
$params = array('interactive_verification_start' => 'xmlns:xsi=\'http://www.w3.org/2001/XMLSchema-instance\' xmlns=\'http://openhbx.org/api/terms/1.0\'', 'individual' => array('id' => '1234', 'person' => array ('id' => '1234', 'person_name' => array('person_surname' => 'Edward', 'person_given_name' => 'Ann'), 'addresses' => array ('address' => array ('type' => 'urn:openhbx:terms:v1:address_type#mailing', 'address_line_1' => '87 Westerfield Plaza', 'location_city_name' => 'Seaside','location_state_code' => 'MD', 'postal_code' => '13455') ), 'phones' => array ('phone' => array ('type' => 'urn:openhbx:terms:v1:phone_type#mobile', 'full_phone_number' => '14016906878','is_preferred' => 'false') )  ), 'person_demographics' => array ('sex' => 'urn:openhbx:terms:v1:gender#male', 'birth_date' => '19780806','created_at' => '2015-08-12T16:29:20Z' ) ) );
/* address not authed */
$params = array('interactive_verification_start' => 'xmlns:xsi=\'http://www.w3.org/2001/XMLSchema-instance\' xmlns=\'http://openhbx.org/api/terms/1.0\'', 'individual' => array('id' => '324', 'person' => array ('id' => '3453', 'person_name' => array('person_surname' => 'RODRIGUES', 'person_given_name' => 'RICKI'), 'addresses' => array ('address' => array ('type' => 'urn:openhbx:terms:v1:address_type#home', 'address_line_1' => '600 10th', 'location_city_name' => 'Minneapolis','location_state_code' => 'MN', 'postal_code' => '55414') ), 'phones' => array ('phone' => array ('type' => 'urn:openhbx:terms:v1:phone_type#home', 'full_phone_number' => '5719999999','is_preferred' => 'true') )  ), 'person_demographics' => array ('sex' => 'urn:openhbx:terms:v1:gender#female', 'birth_date' => '19820427','created_at' => '2015-08-12T16:29:20Z' ) ) );
/* address authed */
$params = array('interactive_verification_start' => 'xmlns:xsi=\'http://www.w3.org/2001/XMLSchema-instance\' xmlns=\'http://openhbx.org/api/terms/1.0\'', 'individual' => array('id' => '1234', 'person' => array ('id' => '1234', 'person_name' => array('person_surname' => 'Powers', 'person_given_name' => 'Veronica'), 'addresses' => array ('address' => array ('type' => 'urn:openhbx:terms:v1:address_type#home', 'address_line_1' => '70 Main St','address_line_2' => 'APT 35', 'location_city_name' => 'Washington','location_state_code' => 'DC', 'postal_code' => '20580') ), 'phones' => array ('phone' => array ('type' => 'urn:openhbx:terms:v1:phone_type#home', 'full_phone_number' => '2025550008','is_preferred' => 'true') )  ), 'person_demographics' => array ('ssn' => '068745108', 'sex' => 'urn:openhbx:terms:v1:gender#female', 'birth_date' => '19520605','created_at' => '2015-08-12T16:29:20Z' ) ) );
/* address authed */
$params = array('individual' => array('id' => '1234', 'person' => array ('id' => '1234', 'person_name' => array('person_surname' => 'Powers', 'person_given_name' => 'Veronica'), 'addresses' => array ('address' => array ('type' => 'urn:openhbx:terms:v1:address_type#home', 'address_line_1' => '70 Main St','address_line_2' => 'APT 35', 'location_city_name' => 'Washington','location_state_code' => 'DC', 'postal_code' => '20580') ), 'phones' => array ('phone' => array ('type' => 'urn:openhbx:terms:v1:phone_type#home', 'full_phone_number' => '2025550008','is_preferred' => 'true') )  ), 'person_demographics' => array ('ssn' => '068745108', 'sex' => 'urn:openhbx:terms:v1:gender#female', 'birth_date' => '19520605','created_at' => '2015-08-12T16:29:20Z' ) ) );
/* address authed */
// $params = array('individual' => array('id' => '1234', 'person' => array ('id' => '1234', 'person_name' => array('person_surname' => 'Powers', 'person_given_name' => 'Veronica'), 'addresses' => array ('address' => array ('type' => 'urn:openhbx:terms:v1:address_type#home', 'address_line_1' => '70 Main St','address_line_2' => 'APT 35', 'location_city_name' => 'Washington','location_state_code' => 'DC', 'postal_code' => '20580') ), 'phones' => array ('phone' => array ('type' => 'urn:openhbx:terms:v1:phone_type#home', 'full_phone_number' => '2025550008','is_preferred' => 'true') )  ), 'person_demographics' => array ('sex' => 'urn:openhbx:terms:v1:gender#female', 'birth_date' => '19520605','created_at' => '2015-08-12T16:29:20Z' ) ) );
print_r($params);
/* */
 $result = $client->process($params);
echo "<br><br>";
   print $client->__getLastRequest()."\n";
echo "<br><br>";
var_dump($result);
/* */
?>
