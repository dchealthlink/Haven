<?php
/*
session_start();
*/
include "inc/qdbconnect.php";
/* include("inc/header_inc.php"); */

$check_no = 0;
$recordid = 0;

$fnm = "Renewals_Report_28Oct.csv";

$handle = fopen("/tmp/".$fnm, "r");
$badlog = fopen("/tmp/qhp_bad_log.".(date("Ymd")), "w");

$goodcount = 0;
$badcount = 0;
if ($handle) {
   while (!feof($handle)) {
       $buffer = fgets($handle, 4096);
/*       echo $buffer."<br>"; */
	$dummy = explode("|",$buffer);


	if ($dummy[0]) {

		$sql = "INSERT INTO  qhp_renewals_ics_102815 ";

//   integratedcaseref | pdccasereference | producttype | eligibilitystatus | reassessmentdate | renewaloutcome | datasource 



		$sql.= " (  integratedcaseref , pdccasereference , producttype , eligibilitystatus , reassessmentdate , lastwritten , datasource) VALUES ( ";
		$sql.="'".trim($dummy[0])."',";
		if ($dummy[1]) {
		$sql.="'".trim($dummy[1])."',";
		} else {
		$sql.="null,";
		}
		if ($dummy[6]) {
		$sql.="'".trim($dummy[6])."',";
		} else {
		$sql.="null,";
		}
		if ($dummy[8]) {
		$sql.="'".trim($dummy[8])."',";
		} else {
		$sql.="null,";
		}
		if ($dummy[9]) {
		$sql.="'".trim($dummy[9])."',";
		} else {
		$sql.="null,";
		}
		if ($dummy[10]) {
		$sql.="'".trim($dummy[10])."',";
		} else {
		$sql.="null,";
		}
		$sql.="'".$fnm."') ;";
		}

		$recordid = $recordid + 1;

//		$sql = str_replace("'","''",$sql);
//		echo $sql."<br>";
		$result = pg_exec($db,$sql); 
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
