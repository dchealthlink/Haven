<?php
/*
session_start();
*/
include "inc/qdbconnect.php";
/* include("inc/header_inc.php"); */

$check_no = 0;
$recordid = 0;

$fnm = "use_case_action.table";
$handle = fopen("/tmp/".$fnm, "r");
$badlog = fopen("/tmp/uc_action_table_log.".(date("Ymd")), "w");

$goodcount = 0;
$badcount = 0;
if ($handle) {
   while (!feof($handle)) {
       $buffer = fgets($handle, 4096);
/*       echo $buffer."<br>"; */
	$dummy = explode("|",$buffer);


	if ($dummy[0]) {

		$sql = "insert into use_case_action values ( '".$dummy[0]."','".$dummy[1]."','".$dummy[2]."','".$dummy[3]."', '".$dummy[4]."', '".$dummy[5]."',  ";
		$sql.= "'".$dummy[6]."','".$dummy[7]."','".$dummy[8]."','".$dummy[9]."')  ";
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
