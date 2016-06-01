<?php
include (dirname(__FILE__) . "/adLdap/src/adLDAP.php");

// attempt db connection
$dbh = pg_connect("host=localhost dbname=legacy  user=root");
if (!$dbh) {
    die("Error in connection: " . pg_last_error());
}

//Connect to AD server
$initsql = "SELECT employee_id, temp_word, fisma_group, admin_group  FROM employee_temp WHERE check_flag = 1 limit 1";
$initresult = pg_query($dbh, $initsql);
$numrows = pg_num_rows($initresult) ;

if ($numrows > 0) {
	list ($temp_emp, $temp_pw, $adGroup, $adAdmin) = pg_fetch_row($initresult,0) ;
} else {

        $sql = "SELECT to_char(now(),'YYMMDDHHMISSMS') as key_val, notice_subject, notice_text, notice_default_group_cd, notice_template, notice_level, now() FROM notice_code WHERE notice_cd = 'admin_fail'";
	
        $result = pg_exec($dbh,$sql);
        if(pg_ErrorMessage($dbh))
                {
                DisplayErrMsg(sprintf("Executing %s ", $sql)) ;
                DisplayErrMsg(sprintf("Error: %s", pg_ErrorMessage($db))) ;
                }

        list ($key_val, $notice_subject, $notice_text, $notice_default_group_cd, $notice_template, $notice_level, $post_timestamp ) = pg_fetch_row($result, 0);
	$email = 'support@ignitetrx.com';

	$errsql = "INSERT into notification (
        notification_id,
        notice_cd,
        notice_group_cd,
        notice_subject,
        notice_text,
        notice_level,
        posting_process,
        post_timestamp,
        notice_email,
        notice_template) values
        ('".$key_val."','admin_fail','"
        .$notice_group_cd."','"
        .$notice_subject."','"
        .$notice_text."','"
        .$notice_level."','AD get users','"
        .$post_timestamp."','"
        .$email."','"
        .$notice_template."')";

        $errresult = pg_exec($dbh,$errsql);

}	

/*
$options = array('admin_username' => 'Administrator',
			'admin_password' => 'Zachary!1');
*/

$options = array('admin_username' => $temp_emp,
			'admin_password' => $temp_pw);
        try {
	$adldap = new adLDAP($options);
        }
        catch (adLDAPException $e) {
            echo $e; exit();   
        }
//Temporary assignments for variables, should be passed at call time instead used for testing
//$adUser = 'testone';
/*  $adGroup = 'Domain Users'; */
//$adUserPassword ='Zachary!1';
/*$username = 'testone';
$password ='Zachary!1';

$authUser = $adldap->authenticate($username, $password);
if ($authUser == true) {
  echo "User authenticated successfully";
}
else {
  echo "User authentication unsuccessful";
}
*/
// authenticate a username/password
if (0) {
	$result = $adldap->authenticate($adUser, $adUserPassword);
	print "Result from the authenticate username/password\n";
	var_dump($result);
}


// retrieve the group membership for a user
if (0) {
	$result = $adldap->$adUser()->groups($adGroup);
	print_r($result);
}

// retrieve information about a user
if (0) {
    // Raw data array returned
	$result = $adldap->user()->info("$adUser");
	print "Start of user info \n";
	print_r($result);
}

// check if a user is a member of a group
if (0) {
	$result = $adldap->user()->inGroup($adUser,$adGroup);
	print "$adUser is a member of $adGroup:  $result  \n";
}

$usernames = $adldap->user()->all();
foreach ($usernames as $username => $val)
{
if($adldap->user()->inGroup($val,$adGroup))
{
	print "$val\n";
$sql = "insert into daves_ad_users values ('".$val."', now() )";
//$sql = "SELECT * FROM app_user where user_id = '00001'";
$result = pg_query($dbh, $sql);
//while ($row = pg_fetch_array($result)) {
//    echo "user_id: " . $row[0] . "<br />";
//    echo "user_name: " . $row[1] . "<p />";
}else
	{	
	print "$val is not a member of $adGroup \n";	
	//print "$username = $val\n";
}
}
// free memory
pg_free_result($result);
// close connection
pg_close($dbh);
?>
