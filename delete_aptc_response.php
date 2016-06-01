<?php
session_start();
include("inc/dbconnect.php");

$sql = "DELETE FROM aptc_response_type_list_user WHERE user_id = '".$_GET['uid']."' and response_type = '".$_GET['rtype']."'";

$result = execSql($db,$sql,$debug);

header( "Location: select_aptc_response.php?search_usr_id=".$_GET['uid']);
?>

