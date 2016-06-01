<?php
session_start();
include("inc/dbconnect.php");
// session_unregister("search_where");
// session_register("search_where");

$search_where = "";

if ($employee_id) {
		$search_where.= " (employee_id = '".$employee_id."') AND ";
}
if ($first_name) {
	$search_where.= " (upper(first_name) like upper('%".$first_name."%')) AND ";
}
if ($last_name) {
	$search_where.= " (upper(last_name) like upper('%".$last_name."%')) AND ";
}

if ($employee_type) {
	$search_where.= " (employee_type = '".$employee_type."') AND ";
}
if ($city) {
	$search_where.= " (city = '".$city."') AND ";
}
if ($state) {
	$search_where.= " (state = '".$state."') AND ";
}
if ($supervisor_id) {
	$search_where.= " (supervisor_id = '".$supervisor_id."') AND ";
}
if ($department_id) {
	$search_where.= " (department_id = '".$department_id."') AND ";
}
if ($status) {
	$search_where.= " (status = '".$status."') AND ";
}
if ($from_date AND !$to_date) {
        $search_where.= " (".$date_type." >= '".$from_date."') AND ";
}

if ($to_date AND !$from_date) {
        $search_where.= " (".$date_type." <= '".$to_date."') AND ";
}
if ($to_date AND $from_date) {
        $search_where.= " (".$date_type." <= '".$to_date."' AND ".$date_type." >= '".$from_date."') AND ";
}


if ($search_where) {
	$search_where = substr($search_where,0,-5);
}


header ("Location: search_employee_result.php?calling=".$calling);

?>
