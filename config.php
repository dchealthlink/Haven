<?php

error_reporting(E_ERROR);

$sesssql = "SELECT curr_session_id, first_login, last_touch, now()::timestamp - last_touch as curr_diff, case when (now()::timestamp - last_touch) > '00:45:00' then 'Y' else 'N' end as timeout_param, user_id, page_hits + 1 FROM curr_session WHERE curr_session_id = '".(session_id())."'";
        $sess_result = pg_exec($db,$sesssql);
        list ($sess_id, $sess_first, $sess_last_touch, $sess_diff, $timeout_param, $sess_user_id, $sess_page_hits) = pg_fetch_row($sess_result,0);

        if ($sess_id) {
                $upd_sql = "UPDATE curr_session set page_hits = ".$sess_page_hits.", last_touch = now() WHERE curr_session_id = '".$sess_id."'";
                $upd_result = pg_exec($db,$upd_sql);
        }
        if ($timeout_param == 'Y') {
                header("Location: index.php?msg=timeout");
                exit;
        }


$locality_sql = "select * from configuration where locality in (select locality from locality_config where active = '1' limit 1)";

        $locality_result = pg_exec($db,$locality_sql);

        if(pg_ErrorMessage($db))
                {
                DisplayErrMsg(sprintf("Error in executing %s statement", $locality_sql)) ;
                DisplayErrMsg(sprintf("Error: %s", pg_ErrorMessage($db))) ;
                };

        $rownum = 0;

        while ($row = pg_fetch_array($locality_result,$rownum)) {
        list($app_locality, $config_field[$rownum], $config_field_value[$rownum]) = pg_fetch_row ($locality_result, $rownum);

        $$config_field[$rownum] = $config_field_value[$rownum];

        $rownum = $rownum+1;
        }


//change 'yes' to 'no' if you dont want emails sent to clients thanking them when invoices are paid
$emailoption = 'no';


// Display error messages
function DisplayErrMsg($message) {
printf("<BLOCKQUOTE><H2><FONT COLOR=\"#CC0000\">
	%s</FONT></H2></BLOCKQUOTE>\n", $message);
}
?>
