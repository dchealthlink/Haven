<?php
include("inc/qdbconnect.php");
$outfile = fopen("/tmp/serv_log_batch.".(date("YmdHis")),"w");
$handle = fopen("/tmp/".$_GET['loadfname'],"r");

while (!feof($handle)) {
       $buffer = fgets($handle, 4096);
       $sidf = explode("|",$buffer);


$presql = "SELECT ws.service_id, ws.service_url, wsf.function_name FROM testweb_service ws, testweb_service_function wsf WHERE ws.service_id = wsf.service_id AND ws.service_id = ".$sidf[0]." AND wsf.function_name ='".$sidf[1]."'";

$preresult = pg_exec($db, $presql);
list ($serviceId, $url, $functionName) = pg_fetch_row($preresult, 0);

echo "<br>";
// $url = "http://10.82.54.209:8001/soa-infra/services/EnrollApp/EnrollAppRIDPFedSvc/enrollappridpfedsvc_client_ep?WSDL";
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

$sql = "SELECT ind_id, person_id, person_surname, person_given_name, address_type, address_line_1, address_line_2, location_city_name, location_state_code, postal_code, phone_type, full_phone_number, is_preferred, ssn, gender, birthdate, created_at FROM testload_data WHERE ind_id = '".$sidf[2]."'";
$result = pg_exec($db, $sql);
list ($indId, $pId, $personSurname, $personGivenName, $addressType, $addressLine1, $addressLine2, $locationCityName, $locationStateCode, $postalCode, $phoneType, $fullPhoneNumber, $isPreferred, $ssn, $gender, $birthDate, $createdAt) = pg_fetch_row($result, 0);

/* address authed */
/* address authed */
switch ($sidf[1]) {
	case 'Interactive_Verification' :
 	$params = array('individual' => array('id' => $indId, 'person' => array ('id' => $pId, 'person_name' => array('person_surname' => $personSurname, 'person_given_name' => $personGivenName), 'addresses' => array ('address' => array ('type' => $addressType, 'address_line_1' => $addressLine1, 'location_city_name' => $locationCityName,'location_state_code' => $locationStateCode, 'postal_code' => $postalCode,'location_postal_extension_code' => '4610') ), 'emails' => array('email' => array('type' => 'urn:openhbx:terms:v1:email_type#home', 'email_address' => 'alee@latz.net' ) ) ,      'phones' => array ('phone' => array ('type' => $phoneType, 'full_phone_number' => $fullPhoneNumber, 'is_preferred' => $isPreferred) )  ), 'person_demographics' => array ('sex' => $gender , 'birth_date' => $birthDate,'created_at' => $createdAt ) ) );
	break;
	case 'Interactive_Verification' :
 $params = array ('session_id' => '0F0D4EA586608ED06B17C71DF08037B0.preciseId6-1507291433060180492888929', 'transaction_id' => '?', 'question_response' => array ( 'question_id' => '1', 'answer' => array ( 'response_id' => '4', 'response_text' => '?')) , 'question_response' => array ( 'question_id' => '2', 'answer' => array ( 'response_id' => '3', 'response_text' => '?')) , 'question_response' => array ( 'question_id' => '3', 'answer' => array ( 'response_id' => '3', 'response_text' => '?')) , 'question_response' => array ( 'question_id' => '4', 'answer' => array ( 'response_id' => '5', 'response_text' => '?')))       ;
	break;
	case 'process' :
$params = array('individual' => array('id' => $indId, 'person' => array ('id' => $pId, 'person_name' => array('person_surname' => $personSurname, 'person_given_name' => $personGivenName), 'addresses' => array ('address' => array ('type' => $addressType, 'address_line_1' => $addressLine1,'address_line_2' => $addressLine2, 'location_city_name' => $locationCityName,'location_state_code' => $locationStateCode, 'postal_code' => $postalCode) ), 'phones' => array ('phone' => array ('type' => $phoneType, 'full_phone_number' => $fullPhoneNumber,'is_preferred' => $isPreferred) )  ), 'person_demographics' => array ('ssn' => $ssn, 'sex' => $gender, 'birth_date' => $birthDate,'created_at' => $createdAt ) ) );

	break;
	case 'ssa-whatever' :
$params = array('SSACompositeIndividualRequest' => array ( 'Person' => array( 'PersonSSNIdentification' => $ssn, 'PersonName' => array( 'PersonGivenName' => $personSurname, 'PersonSurName' => $personGivenName) , 'PersonBirthDate' => array( 'Date' => $birthDate)), 'RequestCitizenshipVerificationIndicator' => 'true', 'RequestIncarcerationVerificationIndicator' => 'true', 'RequestTitleIIMonthlyIncomeVerificationIndicator' => 'false', 'RequestTitleIIAnnualIncomeVerificationIndicator' => 'false', 'RequestQuartersOfCoverageVerificationIndicator' => 'false'));
	break;
	case 'vlp-whatever' :
/*
$params = array ('Agency3InitVerifRequestSet' => array( 'DHSID' => array ( 'I551DocumentID' => array ( 'AlienNumber' => '060800000', 'ReceiptNumber' => 'SXX023151511' , 'DocExpirationDate' => '20XX-08-31')) 'FirstName' => 'EXXX', 'LastName' => 'AXXX', 'DateOfBirth' => '19XX-02-24' , 'RequestedCoverageStartDate' => '2015-08-10', 'FiveYearBarApplicabilityIndicator' => 'true' , 'RequestSponsorDataIndicator' => 'true', 'RequestGrantDateIndicator' => 'true', 'RequesterCommentsForHub' => 'Initial verification request', 'CategoryCode' => 'C40'));
*/
	break;
}

print_r($params);
echo "<br>-----------------<br>";
// $params = array('individual' => array('id' => '1234', 'person' => array ('id' => '1234', 'person_name' => array('person_surname' => 'Edward', 'person_given_name' => 'Ann'), 'addresses' => array ('address' => array ('type' => 'urn:openhbx:terms:v1:address_type#mailing', 'address_line_1' => '087 Westerfield Plaza', 'location_city_name' => 'Seaside','location_state_code' => 'MD', 'postal_code' => '13455','location_postal_extension_code' => '4610') ), 'emails' => array('email' => array('type' => 'urn:openhbx:terms:v1:email_type#home', 'email_address' => 'alee@latz.net' ) ) ,      'phones' => array ('phone' => array ('type' => 'urn:openhbx:terms:v1:phone_type#mobile', 'full_phone_number' => '14944520450','is_preferred' => 'true') )  ), 'person_demographics' => array ('sex' => 'urn:openhbx:terms:v1:gender#male', 'birth_date' => '19820605','created_at' => '2015-08-12T16:29:20Z' ) ) );
// print_r($params);
/* */
   fputs($outfile,date("Y-m-d H:i:s")." -------------------------- Start ----------------------------\n");
   fputs($outfile,date("Y-m-d H:i:s")." -- Open for service: ".$sidf[0]."  function:  ".$sidf[1].".  person: ".$indId ."\n");
// $result = $client->Interactive_Verification($params);
 $result = $client->$functionName($params);
echo "<br><br>";
   print $client->__getLastRequest()."\n";
   $lr = $client->__getLastRequest();
   fputs($outfile,date("Y-m-d H:i:s")." -- ".($lr)."\n\n");
//   fputs($outfile,date("Y-m-d H:i:s")." -- ".var_dump($result)."\n\n") ;
echo "<br><br>";
 var_dump($result);
   fputs($outfile,date("Y-m-d H:i:s")." -- Close\n");
   fputs($outfile,date("Y-m-d H:i:s")." --------------------------- End -----------------------------\n");
/* */
}
	fclose($handle);
	fclose($outfile);
?>
