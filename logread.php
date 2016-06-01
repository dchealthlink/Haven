<?php
session_start();
include "inc/dbconnect.php";
include("inc/header_inc.php");



$sql = "SELECT device_ip, device_type, device_id, device_last_read FROM device WHERE status = 'A' ORDER BY device_id";

$result = execSql($db, $sql, $debug);
echo $sql."<br>";
$rownum = 0;
while($row = pg_fetch_array($result, $rownum)) {

	list($read_device_ip, $read_device_type, $read_device_id, $read_device_last_read) = pg_fetch_row($result, $rownum);

$read_date = date("Y-m-d");


/* $handle = fopen("/tmp/fms-pollTEST.txt", "r"); */
$handle = fopen("/tmp/".$read_date."_POLL_".$read_device_id, "r");

echo "hey tom the file to read from is ".$read_date."_POLL_".$read_device_id."<br>";
if ($handle) {
   while (!feof($handle)) {

$log_action = null;
$log_code = null;
$log_subcode = null;
$log_state = null;
$employee_id = null;
$log_time = null;
$log_dept = null;
$department_id = null;

       $buffer = fgets($handle, 4096);
       echo $buffer."<br>";
	$log_timestamp = substr($buffer,0,19);
	$log_action = substr($buffer,20,7);
	$poll_1 = substr($buffer,29,2);
	$log_code = substr($buffer,36,2);
	switch ($log_code) {
	case 'AA':
		$log_subcode = substr($buffer,38,2);
		$log_time = substr($buffer,43,12);

	break;
	case 'BP':
		$log_subcode = substr($buffer,38,3);

		switch ($log_subcode) {
		case '000':
			$log_state = substr($buffer,41,1);
			$employee_id = substr($buffer,43,5);
			$log_time = substr($buffer,50,12);

		break;
		case '001':
			$log_state = substr($buffer,41,1);
			$employee_id = substr($buffer,43,5);
			$log_time = substr($buffer,50,12);

		break;
		case '002':
			$log_dept = substr($buffer,41,1);
			$department_id = substr($buffer,43,6);
			$poll_6 = substr($buffer,50,1);
			$log_state = substr($buffer,51,1);
			$employee_id = substr($buffer,52,5);
			$log_time = substr($buffer,59,12);

		break;
		}
	break;
	}

	if ($log_timestamp > $read_device_last_read) {

		if ($log_timestamp) {
			$log_sql = "INSERT INTO clocklog (log_timestamp, log_action, log_code, log_subcode, log_state, employee_id, log_time, log_dept, department_id, device_id) VALUES ('".$log_timestamp."','".$log_action."','".$log_code."','".$log_subcode."','".$log_state."','".$employee_id."','".$log_time."','".$log_dept."','".$department_id."','".$read_device_id."')";
			$sql = ereg_replace("''","null",$log_sql);
			$log_result = execSql($db,$log_sql,$debug);
echo $log_sql."<br>";

			$upd_sql = "UPDATE device SET device_last_read = '".$log_timestamp."' WHERE device_id = '".$read_device_id."'";

echo $upd_sql."<br>";
			$upd_result = execSql($db,$upd_sql,$debug);
		}
	}
   }
   fclose($handle);
}

$rownum = $rownum + 1;
}
?> 
