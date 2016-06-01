<?php
 $connection = pg_connect("host=10.3.16.119 dbname=testdb user=tfahey") or die ("Unable to connect!"); 
 /* $connection = pg_connect("host=localhost dbname=testdb user=tfahey password=Zachary1") or die ("Unable to connect!");  */

$query = "SELECT user_id, user_name, user_type, password, email, debug, notify, start_proc, start_key, start_fld, user_level, verbose_flag, splash_flag FROM app_user WHERE user_id = '00001'";
/* $query.= " AND (password = '".$password."' OR user_id = 'admin' OR (password = '".crypt($password,$name)."'))";  */
/* $query.= " AND (password = '".crypt($password,$name)."' OR user_id = 'admin')"; */
echo $query;
$result = pg_exec($connection, $query);
?>
