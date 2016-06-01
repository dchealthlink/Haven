<?php
include ("inc/qdbconnect.php");
if ($_POST['Submit']) {
	if ($_POST['indId'] and $_POST['personId'] AND $_POST['personSurname'] AND $_POST['personGivenName']) {
		$persql = "INSERT INTO testload_data (ind_id, person_id, person_surname, person_given_name, ssn, gender, birthdate, created_at) VALUES ('".$_POST['indId']."','".$_POST['personId']."','".$_POST['personSurname']."','".$_POST['personGivenName']."','".$_POST['ssn']."','".$_POST['gender']."','".$_POST['birthDate']."',now())" ;
		$perresult = pg_exec($persql);
		$mindId = $_POST['indId'];
	} else {
		$mindId = $_POST['mindId'];
	}
	if ($_POST['multType'] and $_POST['multIter'] AND $_POST['multLabel'] AND $_POST['multValue']) {

		$detsql = "INSERT INTO testload_data_mult (ind_id, mult_type, mult_iteration, mult_label, mult_value) VALUES ('".$mindId."','".$_POST['multType']."','".$_POST['multIter']."','".$_POST['multLabel']."','".$_POST['multValue']."')";
		$perresult = pg_exec($detsql);
	}

}
header("location: enter_person.php?id=".$mindId);
?>
