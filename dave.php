<?php
include (dirname(__FILE__) . "/adLdap/src/adLDAP.php");

// attempt db connection
$dbh = pg_connect("host=localhost dbname=legacy  user=root");
if (!$dbh) {
    die("Error in connection: " . pg_last_error());
}
//simulate pull of admin variabels from database
//$admin_username = 'Administrator';
//$admin_password = 'Zachary!1';

//Connect to AD server

$options = array('admin_username' => 'Administrator',
			'admin_password' => 'Zachary!1');
        try {
        catch (adLDAPException $e) {
            echo $e; exit();   
        }
//Temporary assignments for variables, should be passed at call time instead used for testing
//$adUser = 'testone';
$adGroup = 'Domain Users';
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
$sql = "insert into daves_ad_users values ('$val')";
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
