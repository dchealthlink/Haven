<?php
session_start();
include "inc/dbconnect.php";
include("inc/header_inc.php");

$handle = fopen("/tmp/bowie-emp-name-number.txt", "r");
if ($handle) {
   while (!feof($handle)) {
       $buffer = fgets($handle, 4096);
       echo $buffer."<br>";
	$dummy = explode(",",$buffer);
/*
	$pw= crypt($first_name,(strtolower(substr($first_name,0,1)).trim(strtolower(substr($last_name,0,28)))));
*/
	$pw= strtolower($dummy[2]);

	$sql = "INSERT INTO employee (employee_id, first_name, mid_init, last_name, suffix, employee_type, city, state, status, password) VALUES ('".$dummy[0]."','".$dummy[2]."','".$dummy[3]."','".$dummy[4]."','".$dummy[5]."','user','Bowie','MD','A','".$pw."')";
	$sql = ereg_replace("''","null",$sql);
	$result = execSql($db,$sql,$debug);
   }
   fclose($handle);
}
?> 
