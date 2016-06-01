<?php
include (dirname(__FILE__) . "/adLdap/src/adLDAP.php");
$options = array(adminUser=>'testone', adminPassword=>'zachary!1');
echo $options["adminUser"];
echo "\n";
echo $options["adminPassword"];
echo "\n";


// attempt db connection
$dbh = pg_connect("host=localhost dbname=legacy  user=root");
if (!$dbh) {
    die("Error in connection: " . pg_last_error());
}
//Connect to AD server
try {
    $adldap = new adLDAP($options);
}
catch (adLDAPException $e) {
    echo $e;
    exit();   
}

//Temporary assignments for variables, should be passed at call time instead used for testing
$adUser = 'testtwo';
$adGroup = 'Domain Users';
$adUserPassword ='Zachary!2';

// authenticate a username/password
if (0) {
	$result = $adldap->authenticate($adUser, $adUserPassword);
	print "Result from the authenticate username/password\n\n\n";
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
		print "Start of user info for ".$val." \n";
//	print_r($result);
		foreach ($result as $a ) {
			foreach($a as $b=>$e) {
				foreach($e as $c => $d) {
					if ($b == 'displayname' and $d != '1') {
						print $b." for ".$val."   is ".$d." \n";
					}
				}
//				print "thingee is ".$e." and key is ".$b."   and value is ".$e." \n";
			}
		}
	}
// }

// check if a user is a member of a group
if (0) {
	$result = $adldap->user()->inGroup($adUser,$adGroup);
	print "$adUser is a member of $adGroup:  $result  \n";
}



print "\n\n\n\n";

$usernames = $adldap->user()->all();
foreach ($usernames as $username => $val)
{
if($adldap->user()->inGroup($val,$adGroup))
{
//	print "$val\n";
$sql = "insert into daves_ad_users values ('$val')";
//$sql = "SELECT * FROM app_user where user_id = '00001'";
$result = pg_query($dbh, $sql);
//while ($row = pg_fetch_array($result)) {
//    echo "user_id: " . $row[0] . "<br />";
//    echo "user_name: " . $row[1] . "<p />";
	print "$val is a member of $adGroup \n";	
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
