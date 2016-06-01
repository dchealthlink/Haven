<?php
session_start();
include("inc/dbconnect.php");


print_r($_POST);
echo "<br><br>";

if ($UPDATEAPP) {


	for ($i = 0; $i < count($_POST['relation']); $i++ ) {
		$updsql = "UPDATE application_relation SET relationship = '".$_POST['relation'][$i]['relationship']."' WHERE applid = '".$_POST['appl_id']."' AND personid = '".$_POST['relation'][$i]['rperson']."' AND crosspersonid = '".$_POST['relation'][$i]['cperson']."' ";
echo $updsql."<br><br>" ;
	}

	for ($i = 0; $i < count($_POST['household']); $i++ ) {
		$updsql = "UPDATE application_household SET household = '".$_POST['household'][$i]['household']."' WHERE applid = '".$_POST['appl_id']."' AND personid = '".$_POST['household'][$i]['personid']."' ";
echo $updsql."<br><br>" ;
	}


	for ($i = 0; $i < count($_POST['taxfile']); $i++ ) {
		$updsql = "UPDATE application_tax SET tax_no = '".$_POST['taxfile'][$i]['id']."', filer_type = '".$_POST['taxfile'][$i]['filertype']."' WHERE applid = '".$_POST['appl_id']."' AND personid = '".$_POST['taxfile'][$i]['personid']."' ";
echo $updsql."<br><br>" ;
	}

}

  	// header("location: update_application.php?applId=".$applId);

?>

