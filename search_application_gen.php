<?php
session_start();
include("inc/dbconnect.php");
//session_unregister("search_where");
//session_register("search_where");
$_SESSION['search_where'] = '';

$search_where = "";

if ($_GET['appl_id']) {
		$search_where.= " (application.applid  = '".$appl_id."') AND ";
}

if ($_POST['appYear']) {
		$search_where.= " (application.appyear  = '".$_POST['appYear']."') AND ";
}
if ($_POST['first_name']) {
	$search_where.= " (application.applid in (select applid from person where upper(personfirstname) like upper('%".$_POST['first_name']."%'))) AND ";
}
if ($_POST['last_name']) {
	$search_where.= " (application.applid in (select applid from person where upper(personlastname) like upper('%".$_POST['last_name']."%'))) AND ";
}

if ($_POST['applname']) {
	$search_where.= " ( application.applName like upper('%".$_POST['applname']."%') AND ";
}
if ($_POST['statecd']) {
	$search_where.= " (application.statecd = '".$_POST['statecd']."') AND ";
}
if ($status) {
	$search_where.= " (application.status = '".$status."') AND ";
}
if ($from_date AND !$to_date) {
        $search_where.= " (application.postdate >= '".$from_date."') AND ";
}

if ($to_date AND !$from_date) {
        $search_where.= " (application.postdate <= '".$to_date."') AND ";
}
if ($to_date AND $from_date) {
        $search_where.= " (application.postdate <= '".$to_date."' AND application.postdate >= '".$from_date."') AND ";
}


if ($search_where) {
	$search_where = substr($search_where,0,-5);
	$_SESSION['search_where'] = $search_where;
}


header ("Location: search_application_result.php?calling=".$calling);

?>
