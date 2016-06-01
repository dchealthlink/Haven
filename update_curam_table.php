<?php
/*
session_start();
*/
include "inc/qdbconnect.php";
/* include("inc/header_inc.php"); */

$check_no = 0;
$recordid = 0;

$fnm = "curam_table_records.csv";
$handle = fopen("/tmp/".$fnm, "r");
$badlog = fopen("/tmp/curam_update_log.".(date("Ymd")), "w");

$goodcount = 0;
$badcount = 0;
if ($handle) {
   while (!feof($handle)) {
       $buffer = fgets($handle, 4096);
/*       echo $buffer."<br>"; */
	$dummy = explode("|",$buffer);


	if ($dummy[0]) {

		$dummy[3] = strlen($dummy[3]) > 3 ? substr($dummy[3],0,-2) : null;

		$sql = "update curam_table set num_records = '".$dummy[1]."', pl_query = '".$dummy[2]."', comments = '".$dummy[3]."' WHERE ctable_name = '".$dummy[0]."' ";
		$sql = str_replace("''","null",$sql);
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
