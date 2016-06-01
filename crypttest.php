<?php
include ("inc/dbconnect.php");
$key = "test";

$sql = "select bank_acct_num, encrypt_iv_value from xa_pay_log where xa_id = '534Fh43776'";

$result = execSql($db, $sql, $debug);

list ($pulldata, $iniv) = pg_fetch_row($result,0);


$crypttext = unencryptData($key, $pulldata, $iniv);
showEcho ("crypttext is ",$crypttext);
?> 
