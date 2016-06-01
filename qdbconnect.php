<?php
 $db = pg_connect("host=localhost dbname=safehaven user=postgres");
// $db = pg_connect("host=10.0.0.6 dbname=testdb user=postgres");
/* $db = pg_connect("host=localhost dbname=nvfoa user=postgres"); */
/*
if (!$_SESSION['userid'] AND basename($_SERVER['PHP_SELF']) != 'index.php') {
        header( "Location: index.php?msg=timeout") ;
        exit;
}
*/
include("inc/wsconfig.php"); 
//  include("inc/gen_functions_inc_test.php"); 
/*
 $retval = add_user_action_log($db,$user_id, $usertype, $PHP_SELF, 'tbd');
*/
?>
