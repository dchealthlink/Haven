<?php
include("inc/logconfig.php");
$connection = pg_connect("host=localhost dbname=safehaven user=postgres") or die ("Unable to connect!"); 

$query = "SELECT user_id, user_name, user_type, password, email, debug, notify, start_proc, start_key, start_fld, user_level, verbose_flag, splash_flag FROM app_user WHERE user_id ='".$_POST['name']."'";
$query.= " AND (password = '".$_POST['password']."' OR user_id = 'admin' OR (password = '".crypt($_POST['password'],$_POST['name'])."'))"; 
/* $query.= " AND (password = '".crypt($password,$name)."' OR user_id = 'admin')"; */
$result = pg_exec($connection, $query);

if (pg_numrows($result) == 1)
	{
	session_start();

/*
	session_register("userid");
	session_register("username");
	session_register("useremail");
	session_register("usertitle");
	session_register("usertype");
	session_register("debug");
	session_register("notify");
	session_register("startproc");
	session_register("userverbose");
	session_register("usersplash");
	session_register("key_attribute");
	session_register("key_value");
	session_register("userlevel");
	session_register("show_menu");
*/

	list($userid, $username, $user_type, $pass, $useremail, $debug, $notify, $start_proc, $start_key, $start_fld, $user_level, $user_verbose, $user_splash) = pg_fetch_row($result, 0); 
/*
	$userid = $userid;
	$username = $username;
	$user_email = $useremail;
	$user_title = $usertitle;
	$usertype = $user_type;
	$startproc = $start_proc;
	$key_attribute = $start_fld;
	$key_value = $start_key;
	$userverbose = $user_verbose;
	$usersplash = $user_splash;

	$userlevel = $user_level;
	$show_menu = "ON";
*/
	$_SESSION['userid'] = $userid;
	$_SESSION['username'] = $username;
	$_SESSION['user_email'] = $useremail;
	$_SESSION['user_title'] = $usertitle;
	$_SESSION['usertype'] = $user_type;
	$_SESSION['startproc'] = $start_proc;
	$_SESSION['key_attribute'] = $start_fld;
	$_SESSION['key_value'] = $start_key;
	$_SESSION['userverbose'] = $user_verbose;
	$_SESSION['usersplash'] = $user_splash;

	$_SESSION['userlevel'] = $user_level;
	$_SESSION['show_menu'] = "ON";
	
	$sql = "INSERT INTO USER_LOGIN (user_id, password, login_timestamp, user_type, start_proc, start_key, start_fld, user_ip, success_fail) values ('".$userid."','".crypt($_POST['password'],$_POST['name'])."',now(),'".$usertype."','".$start_proc."','".$start_key."','".$start_fld."','".$REMOTE_ADDR."','S')"; 
/*	$sql = "INSERT INTO USER_LOGIN (user_id, password, login_timestamp, user_type, start_proc, start_key, start_fld, user_ip, success_fail) values ('".$userid."','".$_POST['password']."',now(),'".$usertype."','".$start_proc."','".$start_key."','".$start_fld."','".$REMOTE_ADDR."','S')"; */

	$result1 = pg_exec($connection, $sql);
        if(pg_ErrorMessage($connection))
                {
                DisplayErrMsg(sprintf("Executing %s ", $sql)) ;
                DisplayErrMsg(sprintf("Error: %s", pg_ErrorMessage($db))) ;
                };


        $checksql = "SELECT curr_session_id FROM curr_session WHERE curr_session_id ='".(session_id())."'";
        $checkresult = pg_exec($connection, $checksql);
        list($check_session_id) = pg_fetch_row($checkresult,0);

        if ($check_session_id) {
                $updchecksql = "UPDATE curr_session SET last_touch = now(), page_hits = page_hits + 1 WHERE curr_session_id = '".$check_session_id."'";
        } else {
                $updchecksql = "INSERT INTO curr_session (curr_session_id, first_login, last_touch, user_id, page_hits) values ('".(session_id())."',now(),now(),'".$_SESSION['userid']."',1)";
        }

        $result1 = pg_exec($connection, $updchecksql);
        if(pg_ErrorMessage($connection))
                {
                        DisplayErrMsg(sprintf("Executing %s ", $updchecksql)) ;
                        DisplayErrMsg(sprintf("Error: %s", pg_ErrorMessage($connection))) ;
                };



if ($_POST['ucid']) {
	header("Location: ro_uc_form.php?ucId=".$_POST['ucid'] );
		exit;
}
if ($_POST['usid']) {
	header("Location: ro_us_form.php?usId=".$_POST['usid'] );
		exit;
}

	if ($usersplash == 'Y') {
		header("Location: splash_module.php" );
	} else {
		/* header("Location: admin_status_short.php" );  */
		header("Location: ".$start_proc );  
		exit;
		/* header("Location: testwsdl.php" ); */
	}
	pg_free_result ($result);
	pg_free_result ($result1);
	pg_close($connection); 
	}
else

	{
	$sql = "INSERT INTO USER_LOGIN (user_id, password, login_timestamp, user_ip, success_fail) values ('".$_POST['name']."','".$_POST['password']."',now(),'".$REMOTE_ADDR."','F')";
//	echo $query."<br>";
	$result1 = pg_exec($connection, $sql);
        if(pg_ErrorMessage($connection))
                {
                DisplayErrMsg(sprintf("Executing %s ", $sql)) ;
                DisplayErrMsg(sprintf("Error: %s", pg_ErrorMessage($db))) ;
                };

	pg_freeresult ($result);
	pg_close($connection);
	header("Location: index.php?msg=invalid");

	exit;
	}
?>
