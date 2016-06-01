<?php
session_start();
include("inc/dbconnect.php");

$show_menu="ON";

 include("inc/index_header_inc.php"); 
?>
<HTML>
<head>
<script language = "Javascript">
</script>
</head>
<tr><td>
  <blockquote>
   <h1>APTC check - POC</h1>

 <form name="mainform" method="post" action="check_aptc.php">

	<table border=0 cellspacing=0 cellpadding=2 bordercolor=#eeeeee width=900> 

<?php

 echo "<tr><td colspan=6>&nbsp;</td></tr>";

// echo "<br><br>";
//  print_r($_POST);
echo "<br><br>";
$datastring = '{ ';
 foreach($_POST as $prop => $value) {
	if (is_array($value)) {
 		foreach($value as $prop1 => $value1) {
	//		echo "prop1 = ".$prop1."<br>";
			$appldatastring.=' "Applicant'.$prop1.'" : { "id" : '.$prop1.' ,';
			if (is_array($value1)) {
//				$datastring.=' ( ';
 				foreach($value1 as $prop2 => $value2) {

					switch ($prop2) {
						case 0:
							$label = 'requestorName';
						break;
						case 1:
							$label = 'requestorAge';
				                        $aquery = "SELECT monthly_premium FROM annual_benchmark WHERE fpl_year = '2015' and ".$requestorAge." between start_age and end_age ";
                        				$aresult = pg_exec($db, $aquery) ;
                        				list ($benchmarkAmount) = pg_fetch_array ($aresult, 0) ;
                        				$totalBenchmarkAmount = $totalBenchmarkAmount + $benchmarkAmount;

						break;
						case 2:
							$label = 'householdSize';
						break;
						case 3:
							$label = 'numberKids';
						break;
						case 4:
							$label = 'annualIncome';
							$householdIncome = $householdIncome + $value2;
						break;
						case 5:
							$label = 'isParent';
						break;
						case 6:
							$label = 'idDependant';
						break;
						case 7:
							$label = 'isPregnant';
						break;
						case 8:
							$label = 'numPregnant';
						break;
					}

					$appldatastring.=' "'.$label.'" : "'.$value2.'" ,';
				}
				$appldatastring = substr($appldatastring,0,-1);
				$appldatastring.=' },';
			}
		}
	} else {
		switch ($prop) {
			case 'submit':
			break;
			case 'applid':
			case 'personid':
			case 'aptcPersonId':
				$datastring.=' "'.$prop.'": "'.$value.'" ,';
				$$prop = $value ;
			break;
			default:
	
				if ($prop != 'submit') {
					if (is_numeric($value)) {
						$datastring.=' "'.$prop.'": '.$value.' ,';
					} else {
						$datastring.=' "'.$prop.'": "'.$value.'" ,';
					}
				}
			}
	}
}
$datastring = substr($datastring,0,-1).' } ';

include("call_ws_inc.php");

?>



	<tr><td colspan=6>&nbsp;</td></tr>
	<tr><td colspan=6>&nbsp;</td></tr>
    <tr>
    <td colspan=2><input class="gray" type="Submit" name="formreturn" value="return"></td></tr>
</table>
    </p>
  </form>
</blockquote>
<?

include "inc/footer_inc.php";
?>
</body>
</HTML>
