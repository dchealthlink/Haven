<?
/* =========== function strip_chars ========== */

function strip_chars ($str, $num_chars) {

        $str = substr($str, 0, strlen($str) - $num_chars);

        return $str;

}




/* =========== function hex2bin ========== */

function dec_2_bin ($dec_value, $num_bytes) {

                        $byte_length = strlen(decbin($dec_value));
                        $ret_val = decbin($dec_value);

for ($i=0; $i < (($num_bytes * 8) - $byte_length); $i ++) {

        $ret_val = "0".$ret_val;

}

return $ret_val;

};

/*
function hex2bin ($hex_str) {

for($i = 0; $i<strlen($hex_str); $i += 2) {

        $bin_str.=chr(hexdec(substr($hex_str, $i, 2)));
 }

return $bin_str;

};
*/
/* ======== function add_user_action_log ======= */
function add_user_action_log ($db, $user_id, $action_type, $action_page, $action_event) {

$sql = "insert into user_action_log (user_id, action_type, action_page, action_event, action_timestamp) values ('".$user_id."', '".$action_type."','".$action_page."','".$action_event."', now())";
        $result = pg_exec($db, $sql);

        $retcode = 1;

return $retcode;
};



/* ======== function display_menu_array ======= */
function display_menu_array ($db, $screen_name, $refer_name, $menu_enabled, $u_level) {

$sql ="select * from display_menu where screen_name='".$screen_name."' order by sort_order";

$result = pg_exec($db,$sql);

if(pg_ErrorMessage($db))
        {
        DisplayErrMsg(sprintf("Error in executing %s statement", $sql)) ;
        DisplayErrMsg(sprintf("Error: %s", pg_ErrorMessage($db))) ;
        };
$j = 0;

for ($i = 0; $i < (pg_numrows($result)); $i++) {

        $row = pg_fetch_array($result,$i);

        $display_menu[$i][0] = $row[pg_fieldname($result,2)];
        $display_menu[$i][1] = $row[pg_fieldname($result,1)];
        $display_menu[$i][2] = $menu_enabled ;
	$j = $j + 1;
}
	$display_menu[$j][1] = "Return";
	$display_menu[$j][0] = $refer_name;
	$display_menu[$j][2] = 1;
	if ($u_level > 2) {
		$display_menu[$j + 1][1] = "Select New";
		$display_menu[$j + 1][0] = "select_new.php";
		$display_menu[$j + 1][2] = 1;
	}

return $display_menu;
};



/* ======== function showEcho ======= */
function showEcho ($echo_text, $echo_value) {
	echo "<p>".$echo_text.$echo_value."</p>";
}


/* ======== function execSql ======= */
function execSql($db, $sql_request, $debug) {

$result = pg_exec($db, $sql_request);
if(pg_ErrorMessage($db)) {
	$errmsg=ereg_replace("'","",pg_ErrorMessage($db));
	$sqlreq=ereg_replace("'","",$sql_request);
        $errsql = "INSERT INTO sql_error_log (sql_error_text, sql_query, sql_timestamp) VALUES ('".$errmsg."','".$sqlreq."', now() )";
/*
        if ($debug) {
                DisplayErrMsg(sprintf("Executing %s ", $sql_request)) ;
        }
*/
	$message_data = pg_ErrorMessage($db);
	$result = 'error: '.$errmsg;
/*
        DisplayErrMsg(sprintf("%s", pg_ErrorMessage($db))) ;
*/
        $result = pg_exec($db, $errsql);
	return 'error: '.$errmsg;
	exit;
}
	return $result;
}

/* ======== function errorSql ======= */
function errorSql($db, $errmsg, $sqlreq) {

        $errsql = "INSERT INTO sql_error_log (sql_error_text, sql_query, sql_timestamp) VALUES ('".$errmsg."','".$sqlreq."', now() )";
        $message_data = $errmsg;
        
        $result = pg_exec($db, $errsql);
        return $message_data;


return $result;
}
