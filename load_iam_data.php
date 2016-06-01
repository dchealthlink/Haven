<?php
/*
session_start();
*/
include "inc/qdbconnect.php";
/* include("inc/header_inc.php"); */

$check_no = 0;
$recordid = 0;

$fnm = "IAM_11132015_v1.csv";
$handle = fopen("/tmp/".$fnm, "r");
$badlog = fopen("/tmp/iam_bad_log.".(date("Ymd")), "w");

$goodcount = 0;
$badcount = 0;
if ($handle) {
   while (!feof($handle)) {
       $buffer = fgets($handle, 4096);
/*       echo $buffer."<br>"; */
	$dummy = explode("|",$buffer);


	if ($dummy[2]) {

//	if (is_numeric($dummy[1]) AND is_numeric($dummy[15]) ) {
		$sql = "INSERT INTO iam_users_111615  ";
//	} else {
//		$sql = "INSERT INTO activepolicy_glue_dc101015  ";
//	}

// appref | integratedcaseref | pdccasereference | producttype | periodfromdate | periodtodate | aptcfedcallstatus | availabletaxcreditamount | benchmarkplanmonthlypremium | costsharingreduction | coverageyear | enddate | householdincome | householdincomefpl | maxinstaxcreditamount | participant | rembenhouseholdcontribution | startdate



		$sql.= " (firstname, lastname, login_id, email, statusflag, creation_time, account_type, account_status, datasource, fullname ) VALUES ( ";
		if ($dummy[0])  {
			$dummy[0] = str_replace("'","''",$dummy[0]) ;
			$sql.="'".trim($dummy[0])."',";
		} else {
			$sql.= "null," ;
		}
		if ($dummy[1])  {
			$dummy[1] = str_replace("'","''",$dummy[1]) ;
			$sql.="'".trim($dummy[1])."',";
		} else {
			$sql.= "null," ;
		}
		if ($dummy[2])  {
			$dummy[2] = str_replace("'","''",$dummy[2]) ;
			$sql.="'".trim($dummy[2])."',";
		} else {
			$sql.= "null," ;
		}
		if ($dummy[3])  {
			$dummy[3] = str_replace("'","''",$dummy[3]) ;
			$sql.="'".trim($dummy[3])."',";
		} else {
			$sql.= "null," ;
		}
		if ($dummy[4])  {
			$sql.="'".trim($dummy[4])."',";
		} else {
			$sql.= "null," ;
		}
		if ($dummy[5])  {
			$datedata = explode("-",$dummy[5]) ;
			$newdate = $datedata[1]."-".$datedata[0]."-".$datedata[2] ;
//			$sql.="'".trim($dummy[5])."',";
			$sql.="'".trim($newdate)."',";
		} else {
			$sql.= "null," ;
		}
		if ($dummy[6])  {
			$sql.="'".trim($dummy[6])."',";
		} else {
			$sql.= "null," ;
		}
		if ($dummy[7])  {
			$sql.="'".trim($dummy[7])."',";
		} else {
			$sql.= "null," ;
		}
		$sql.="upper('".trim($dummy[0])." ".trim($dummy[1])."'),";
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
