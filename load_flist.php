<?php
/*
session_start();
*/
include "inc/qdbconnect.php";
/* include("inc/header_inc.php"); */

$check_no = 0;
$recordid = 0;

$fnm = "flist.out";
$handle = fopen("/tmp/".$fnm, "r");
$badlog = fopen("/tmp/flist_bad_log.".(date("Ymd")), "w");

$goodcount = 0;
$badcount = 0;
if ($handle) {
   while (!feof($handle)) {
       $buffer = fgets($handle, 4096);
/*       echo $buffer."<br>"; */
//	$dummy = explode("|",$buffer);
	$dummy = trim($buffer);


	if ($dummy[0]) {

//	if (is_numeric($dummy[1]) AND is_numeric($dummy[15]) ) {
		$sql = "select count(*) from ".$dummy ;
		$result = pg_exec($db,$sql); 
		list ($thecount) = pg_fetch_row($result, 0) ;
		echo "\n".$sql." ==> ".$thecount;
//	} else {
//		$sql = "INSERT INTO activepolicy_glue_dc101015  ";
//	}

// appref | integratedcaseref | pdccasereference | producttype | periodfromdate | periodtodate | aptcfedcallstatus | availabletaxcreditamount | benchmarkplanmonthlypremium | costsharingreduction | coverageyear | enddate | householdincome | householdincomefpl | maxinstaxcreditamount | participant | rembenhouseholdcontribution | startdate



		$sql = "insert into flist_count (tablename, reccount) values ( '".$dummy."', ".$thecount.") ";
}

		$recordid = $recordid + 1;

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
