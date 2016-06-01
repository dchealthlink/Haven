<?php
if (!$datastring) {
	$datastring = $_POST['datastring'] ;
}

$ch = curl_init('http://localhost/web_serv_aptc_short.php');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $datastring);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Accept: application/json',
    'Content-Length: ' . strlen($datastring))
);
$result = curl_exec($ch);


// echo "<br><br> Result ===>  ".$result."  <======== <br><br>";

$deresult = json_decode($result,true) ;

foreach($deresult as $prop => $value) {
        if ( is_array($value)) {
                foreach($value as $prop1 => $value1) {
			switch ($prop1) {
				case 'aptcName':
				case 'annualIncome':
                             //  		echo '<tr><td>'.$prop1.' : </td><td>'.$value1.'</td></tr>';
				case 'annualBenchmark':
				case 'applid':
				case 'householdSize':
				case 'personid':
				case 'user':
				case 'userpw':
				case 'responseFormat':
			//		case 'Temp FPL':
					$inout = 'I';
					$sql = "INSERT INTO application_aptc values ('".$applid."', '".$inout."', '".$prop1."','".$value1."', now() )";
					$result = execSql($db, $sql, $debug) ;
				break;
				default:
					$inout = 'O';
                       	   //     	echo '<tr><td>'.$prop1.' : </td><td>'.$value1.'</td></tr>';
					$sql = "INSERT INTO application_aptc values ('".$applid."', '".$inout."', '".$prop1."','".$value1."', now() )";
					$result = execSql($db, $sql, $debug) ;
			}
                }
        } else {
    //            echo '<br/>Level0a: '. $prop .' : '. $value;
        }
}
	$sql = "SELECT response_type as request_type, response_value as value from application_aptc WHERE applid = '".$applid."' and personid = 'I' and response_type in (select response_type from aptc_response_type_list_user where display_flag = 'Y' and user_id = '".$userid."')  ";
	$preresult = execSql($db,$sql,$debug);
	if (pg_num_rows($preresult) == 0) {
		$sql = "SELECT response_type as request_type, response_value as value from application_aptc WHERE applid = '".$applid."' and personid = 'I' and response_type in (select response_type from aptc_response_type_list where display_flag = 'Y')  ";
	}

$list_label="N";
$orient="horizontal";
echo "<tr><td><table width=450><tr><td valign=top width=50%><table>";

echo ("<tr><td><b>APTC Request Input</b></td></tr>");
echo "<tr><td>";
include ("inc/view_form_inc.php");
echo "</td></tr>";

echo "</table></td>";
echo "</tr>";
echo "<tr><td colspan=6>&nbsp;</td></tr>";



	$sql = "SELECT response_type as request_type, response_value as value from application_aptc WHERE applid = '".$applid."' and personid = 'O' and response_type in (select response_type from aptc_response_type_list_user where display_flag = 'Y' and user_id = '".$userid."')  ";
	$preresult = execSql($db,$sql,$debug);
	if (pg_num_rows($preresult) == 0) {
		$sql = "SELECT response_type, response_value from application_aptc WHERE applid = '".$applid."' and personid = 'O' and response_type in (select response_type from aptc_response_type_list where display_flag = 'Y') ";
	}

$list_label="N";
$orient="horizontal";
echo "<tr><td><table width=450><tr><td valign=top width=50%><table>";

echo ("<tr><td><b>APTC Response Output</b></td></tr>");
echo "<tr><td>";
include ("inc/view_form_inc.php");
echo "</td></tr>";

echo "</table></td>";
echo "</tr>";
echo "</table>";
echo "</table>";

?>
