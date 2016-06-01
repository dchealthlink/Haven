<?php
session_start();
include("inc/dbconnect.php");
/*
session_unregister("search_where");
session_register("search_where");
*/
$search_where = "";

if ($SEARCHCLIENT) {
if ($usecaseId) {
        $search_where.=" (usecaseid = '".$usecaseId."') AND  ";
}

if ($usecaseName) {
	$search_where.= " (usecasename like upper('%".$usecaseName."%')) AND ";
}
if ($priority) {
	$search_where.= " (priority = '".$priority."') AND ";
}
if ($actor) {
	$search_where.= " (usecaseid in (select usecaseid from use_case_action where action_type = 'actor' and actor = '".$actor."')) AND ";
}


if ($search_where) {
	$search_where = substr($search_where,0,-5);
	$_SESSION['search_where'] = $search_where;
}


header ("Location: search_uc_result.php?calling=".$calling);


}


?>
