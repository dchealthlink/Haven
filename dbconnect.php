<?php
// $db = pg_connect("host=10.29.75.20 dbname=testdb user=postgres");
// $db = pg_connect("host=10.0.0.6 dbname=testdb user=postgres");
 $db = pg_connect("host=localhost dbname=safehaven user=postgres");
/*
if (!$_SESSION['userid'] AND basename($_SERVER['PHP_SELF']) != 'index.php') {
        header( "Location: index.php?msg=timeout") ;
        exit;
}
*/

// Emulate register_globals on

 if (!ini_get('register_globals')) {
    $superglobals = array($_SERVER, $_ENV,
        $_FILES, $_COOKIE, $_POST, $_GET);
    if (isset($_SESSION)) {
        array_unshift($superglobals, $_SESSION);
    }
    foreach ($superglobals as $superglobal) {
        extract($superglobal, EXTR_SKIP);
    }
 }



include("inc/config.php");
// include("inc/config.php");
//  include("inc/gen_functions_inc.php"); 
  include("inc/gen_functions_inc_test.php"); 
//  include("inc/gen_functions_es.php"); 
/*
 $retval = add_user_action_log($db,$user_id, $usertype, $PHP_SELF, 'tbd');
*/
?>
