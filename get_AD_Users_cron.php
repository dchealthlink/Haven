<?php
include (dirname(__FILE__) . "/adLdap/src/adLDAP.php");
// $options = array(adminUser=>'testone', adminPassword=>'zachary!1');


// attempt db connection
$dbh = pg_connect("host=localhost dbname=legacy  user=root");
if (!$dbh) {
    die("Error in connection: " . pg_last_error());
} else {
	echo "whatever<br>";
}

	$initsql = "SELECT employee_id, temp_word, fisma_group, admin_group  FROM employee_temp WHERE check_flag = 1 limit 1";
	$initresult = pg_query($dbh, $initsql);
	$numrows = pg_num_rows($initresult) ;

	echo $initsql ;
	if ($numrows > 0) {
        	list ($temp_emp, $temp_pw, $adGroup, $adAdmin) = pg_fetch_row($initresult,0) ;

		$loadldapsql = "SELECT load_cbtuser, load_cbtadmin, load_admin, nonload_user FROM ldap_config LIMIT 1";
		$loadldapresult = pg_query($dbh, $loadldapsql) ;
		list ($load_cbtuser, $load_cbtadmin, $loadadmin, $nonload_user) = pg_fetch_row($loadldapresult, 0) ; 


	} else {

	        $sql = "SELECT to_char(now(),'YYMMDDHHMISSMS') as key_val, notice_subject, notice_text, notice_default_group_cd, notice_template, notice_level, now() FROM notice_code WHERE notice_cd = 'admin_fail'";

        	$result = pg_exec($dbh,$sql);
        	if(pg_ErrorMessage($dbh)) {
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

		$detsql = "INSERT INTO notice_data values ('".$key_val."','post_timestamp','now()')";
	        $detresult = pg_exec($dbh,$detsql);
		$detsql = "INSERT INTO notice_data values ('".$key_val."','user_id','".$temp_emp."')";
	        $detresult = pg_exec($dbh,$detsql);

	}

/* */
$options = array('admin_username' => $temp_emp,
                        'admin_password' => $temp_pw);


//Connect to AD server
try {
    $adldap = new adLDAP($options);
}
catch (adLDAPException $e) {
    echo $e;
    exit();   
}

// authenticate a username/password
if (0) {
	$result = $adldap->authenticate($adUser, $adUserPassword);
	print "Result from the authenticate username/password<br><br><br>";
	var_dump($result);
}


// retrieve the group membership for a user
if (0) {
	$result = $adldap->$adUser()->groups($adGroup);
	print_r($result);
}

// retrieve information about a user
// if (1) {
    // Raw data array returned
	$usernames = $adldap->user()->all();
	foreach ($usernames as $username => $val) {

//		$result = $adldap->user()->info("$adUser");
		$result = $adldap->user()->info("$val");
		print "Start of user info for ".$val." <br>";
//	print_r($result);
		foreach ($result as $a ) {
			foreach($a as $b=>$e) {
				foreach($e as $c => $d) {
					if ($b == 'displayname' and $d != '1') {
						print $b." for ".$val."   is ".$d." <br>";


						$checkadGroup = 'Domain Users';
						$checkadGroup = $nonload_user;
						if ($adldap->user()->inGroup($val,$checkadGroup)) {
							print "$val is a member of $checkadGroup:  $result  <br>";
							$emp_type = '';
						} else {
							print "====> $val is NOT a member of $checkadGroup:  <br>";
						}
						$checkadGroup = 'CBTUSER';
						$checkadGroup = $load_cbtuser ;
//	$result = $adldap->user()->inGroup($val,$checkadGroup);
						if ($adldap->user()->inGroup($val,$checkadGroup)) {
							print "$val is a member of $checkadGroup:  $result  <br>";
							$emp_type = 'basic';
						} else {
							print "====> $val is NOT a member of $checkadGroup:  <br>";
						}
						$checkadGroup = 'CBTADMIN';
						$checkadGroup = $load_cbtadmin ;
						if ($adldap->user()->inGroup($val,$checkadGroup)) {
							print "$val is a member of $checkadGroup:  $result  <br>";
							$emp_type = 'admin';
						} else {
							print "====> $val is NOT a member of $checkadGroup:  <br>";
						}
						$checkadGroup = 'ADMIN';
						$checkadGroup = $loadadmin ;
						if ($adldap->user()->inGroup($val,$checkadGroup)) {
							print "$val is a member of $checkadGroup:  $result  <br>";
							$emp_type = 'su';
						} else {
							print "====> $val is NOT a member of $checkadGroup:  <br>";
						}

						if ($emp_type) {
							$checksql = "SELECT count(*) FROM employee WHERE employee_id = '".$val."'";
							$checkresult = pg_exec($dbh, $checksql) ;
							list ($checkcount) = pg_fetch_row ($checkresult, 0);
//							$checkcount = 0;
							if ($checkcount == 0) {

								$nameex = explode(" ",$d) ;

								$inssql = "INSERT INTO employee (employee_id, first_name, last_name, employee_type, status, hire_date, verbose_flag, splash_flag, email) values ('".$val."', '".$nameex[0]."', '".$nameex[1]."', '".$emp_type."', 'A',  now(), 'N','Y','".$val."@legacyforhealth.org')" ;
								echo $inssql."<br>";
							$insresult = pg_exec($dbh, $inssql) ;

							}
						}
					}
				}
			}
		}
	}
// }

// check if a user is a member of a group
if (0) {
	$result = $adldap->user()->inGroup($adUser,$adGroup);
	print "$adUser is a member of $adGroup:  $result  <br>";
}




$usernames = $adldap->user()->all();
foreach ($usernames as $username => $val)
{
if($adldap->user()->inGroup($val,$adGroup)) {
//	print "$val is a member of $adGroup <br>";	
}else {	
//	print "$val is not a member of $adGroup <br>";	
}
}
// free memory
pg_free_result($result);
// close connection
pg_close($dbh);
/* */
?>
