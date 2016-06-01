<?php
/*
session_start();
*/
include "inc/qdbconnect.php";
/* include("inc/header_inc.php"); */

$check_no = 0;
$recordid = 0;

$fnm = "DCAS_2014_HH7.csv";
$badlog = fopen("/tmp/dcas_fpl_test_log7.".(date("Ymd")), "w");
$handle = fopen("/tmp/".$fnm, "r");

$goodcount = 0;
$badcount = 0;
if ($handle) {
   while (!feof($handle)) {
       $buffer = fgets($handle, 4096);
       echo $buffer."<br><br>"; 
	$dummy = explode("|",$buffer);


	if ($dummy[3]) {

		$sql = "insert into hh_dcas_test ( ";
		$sql.= " testnumber, testcondition, applicant, firstname, lastname, category, updcategory, upd2category, agerange, agedata, gender, maritalstatus, 
wanthelp, wanteligibility, amindian_alaskan, livewith, ssn, ssnvalue, citizenship, residency, street1,  state, zipcode, fiveyear, pregnant, nokids,
pregnancyduedate, pregnancyenddate, infoster, onmedicaid, adultmedicaid, fosterstate, fosterage, weremedicaid, memberrelationship, primarycare, 
taxfilingstatus, jointtax, enterdependent, incomeincluded, incomeexcluded, incomededuction, medbill3mo, incarceration, beencovered, accesstoesi,
costaverage, disabled, blind, longtermcare, eligibilitydeter, fpl2014, fpl2013, programcode, dataset  )";

		$sql.=" values ( ";
if ($dummy[0]) {
	$lasttestnumber = $dummy[0] ;
} else {
	$dummy[0] = $lasttestnumber ;
}
		$sql.="'".$dummy[0]."',";
		$sql.="'".$dummy[1]."',";
		$sql.="'".$dummy[2]."',";
		$sql.="'".$dummy[3]."',";
		$sql.="'".$dummy[4]."',";
		$sql.="'".$dummy[5]."',";
		$sql.="'".$dummy[6]."',";
		$sql.="'".$dummy[7]."',";
		$sql.="'".$dummy[8]."',";
		$sql.="'".$dummy[9]."',";
		$sql.="'".$dummy[10]."',";
		$sql.="'".$dummy[11]."',";
		$sql.="'".$dummy[12]."',";
		$sql.="'".$dummy[13]."',";
		$sql.="'".$dummy[14]."',";
		$sql.="'".$dummy[15]."',";
		$sql.="'".$dummy[16]."',";
		$sql.="'".$dummy[17]."',";
		$sql.="'".$dummy[18]."',";
		$sql.="'".$dummy[19]."',";
		$sql.="'".$dummy[20]."',";
		$sql.="'".$dummy[21]."',";
		$sql.="'".$dummy[22]."',";
		$sql.="'".$dummy[23]."',";
		$sql.="'".$dummy[24]."',";
		$sql.="'".$dummy[25]."',";
		$sql.="'".$dummy[26]."',";
		$sql.="'".$dummy[27]."',";
		$sql.="'".$dummy[28]."',";
		$sql.="'".$dummy[29]."',";
		$sql.="'".$dummy[30]."',";
		$sql.="'".$dummy[31]."',";
		$sql.="'".$dummy[32]."',";
		$sql.="'".$dummy[33]."',";
		$sql.="'".$dummy[34]."',";
		$sql.="'".$dummy[35]."',";
		$sql.="'".$dummy[36]."',";
		$sql.="'".$dummy[37]."',";
		$sql.="'".$dummy[38]."',";
		$sql.="'".$dummy[39]."',";
		$sql.="'".$dummy[40]."',";
		$sql.="'".$dummy[41]."',";
		$sql.="'".$dummy[42]."',";
		$sql.="'".$dummy[43]."',";
		$sql.="'".$dummy[44]."',";
		$sql.="'".$dummy[45]."',";
		$sql.="'".$dummy[46]."',";
		$sql.="'".$dummy[47]."',";
		$sql.="'".$dummy[48]."',";
		$sql.="'".$dummy[49]."',";
		$sql.="'".$dummy[50]."',";
		$sql.="'".$dummy[51]."',";
		$sql.="'".$dummy[52]."',";
		$sql.="'".$dummy[53]."',";
	//	$sql.="'".$dummy[54]."',";
		$sql.="'".$fnm."'";
		$sql.=")  ";
		$sql = str_replace("''","null",$sql);
	echo $sql."<br><br>";
		$result = pg_exec($db,$sql); 
}

		$recordid = $recordid + 1;

	if (is_resource($result)) {
		$goodcount = $goodcount + 1;
	} else {
		$badcount = $badcount + 1;
	 	fputs($badlog, "error - ".$sql."\n\n");
	}


/*		echo $sql."<br><br>"; */



   }
   fclose($badlog);
   fclose($handle);
}

echo "goodcount == ".$goodcount."   and badcount == ".$badcount;

?> 
