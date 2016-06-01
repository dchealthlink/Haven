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


function hex2bin ($hex_str) {

for($i = 0; $i<strlen($hex_str); $i += 2) {

	$bin_str.=chr(hexdec(substr($hex_str, $i, 2)));
 }

return $bin_str;

};

/* ======== function add_user_action_log ======= */
function add_user_action_log ($db, $user_id, $action_type, $action_page, $action_event) {

$sql = "insert into user_action_log (user_id, action_type, action_page, action_event, action_timestamp) values ('".$user_id."', '".$action_type."','".$action_page."','".$action_event."', now())";
        $result = pg_exec($db, $sql);

        $retcode = 1;

return $retcode;
};


/* == function retrieve_keys == */
function retrieve_keys ($db, $str) {

$sql = "select indkey, indrelid, c.oid from pg_index i, pg_class c where i.indrelid = c.oid and c.relname = '".$str."' and indisprimary = 't';";

/*
if ($debug) {
	DisplayErrMsg(sprintf("Executing %s statement", $sql)) ;   
};
*/

	$result = pg_exec($db, $sql);


	$numrows = pg_numrows($result);

	while ($row = pg_fetch_array($result,$rownum))
	{
	global $arr;
	$arr=split(" ",$row[pg_fieldname($result,0)]);
	$arrvals = count($arr);
	$rownum = $rownum + 1;
	}

	return $arrvals;
};

function retrieve_keys_comma ($db, $str) {

$sql = "select indkey from pg_index i, pg_class c where i.indrelid = c.oid and c.relname = '".$str."' and indisprimary = 't';";

/*
if ($debug) {
        DisplayErrMsg(sprintf("Executing %s statement", $sql)) ;
};
*/

        $result = pg_exec($db, $sql);


        $numrows = pg_numrows($result);

        while ($row = pg_fetch_array($result,$rownum))
        {
        $retval=ereg_replace(" ",",",$row[pg_fieldname($result,0)]);
        $rownum = $rownum + 1;
        }

        return $retval;
};


function retrieve_keyfields_comma ($db, $str, $fldarray) {

$sql = "SELECT c.relname, a.attname, a.attnum, a.attlen, a.atttypmod, a.attnotnull, t.typname FROM pg_class c, pg_attribute a, pg_type t WHERE c.relname = '".$str."' and c.oid = a.attrelid and a.attnum > 0 and a.atttypid = t.oid and a.attnum in (".$fldarray.") order by 1, 3;";

/*
if ($debug) {
        DisplayErrMsg(sprintf("Executing %s statement", $sql)) ;
};
*/

        $result = pg_exec($db, $sql);

	$retval = "";
        $numrows = pg_numrows($result);

        while ($row = pg_fetch_array($result,$rownum))
        {
        $retval.=$row[pg_fieldname($result,1)].", ";
        $rownum = $rownum + 1;
        }

	$retval = substr($retval, 0, strlen($retval) - 2);
        return $retval;
};


/* == function valid_application_level == */
function valid_application_level ($db, $tablename, $application_level) {

$sqlreq="SELECT * from application_table where table_name='".$tablename."' ";

switch ($application_level) {
	case "cashier":
		$sqlreq.= "AND table_type='user'";
		break;
	case "user":
		$sqlreq.= "AND table_type='user'";
		break;
	case "admin":
		$sqlreq.= "AND table_type != 'vendor'";
		break;
	case "vendor":
		break;
	default:
		$sqlreq.= "AND table_type='user'";
	}

$result = pg_exec($db, $sqlreq);
$numrows = pg_numrows($result);
return $numrows;
};


/* == function retrieve_keys == */
$numkeys=retrieve_keys($db,$tablename);
if ($debug) {
	for ($i=0; $i < $numkeys; $i++) {
	/*	echo "<p>array value: ".$i." is :".$arr[$i]."</p>"; */
	}
};


/* == function retrieve_columns == */
function retrieve_columns ($str) {

$sqlreq="SELECT c.relname, a.attname, a.attnum, a.attlen, a.atttypmod, a.attnotnull, t.typname ";
$sqlreq.="FROM pg_class c, pg_attribute a, pg_type t ";
$sqlreq.="WHERE c.relname = '".$str."' and c.oid = a.attrelid and a.attnum > 0 and ";
$sqlreq.="a.atttypid = t.oid order by 1, 3";

return $sqlreq;
};

/* == function retrieve_columns_select == */
function retrieve_columns_select ($str, $acc_method) {

$sqlreq="SELECT c.relname, a.attname, a.attnum, a.attlen, a.atttypmod, a.attnotnull, t.typname ";
$sqlreq.=", ta.read_write, ta.sort_order, ta.field_disabled ";
$sqlreq.="FROM pg_class c, pg_attribute a, pg_type t, table_field_access ta ";
$sqlreq.="WHERE c.relname = '".$str."' and c.oid = a.attrelid and a.attnum > 0 and ";
$sqlreq.="a.atttypid = t.oid "; 
$sqlreq.=" and (c.relname::varchar = ta.table_name and a.attname::varchar = ta.field_name and ta.access_type = '".$acc_method."') "; 
$sqlreq.=" order by 1, 9, 3";

return $sqlreq;
};


/* == function retrieve_keys == */
$numkeys=retrieve_keys($db,$tablename);
if ($debug) {
	for ($i=0; $i < $numkeys; $i++) {
	/*	echo "<p>array value: ".$i." is :".$arr[$i]."</p>"; */
	}
};

/* ======== function get_parent_child_field ======= */
function get_parent_child_field ($db, $parent_table, $child_table, $relation_type, $table_name) {

$sql = "select field_name from parent_child_field where parent_table = '".$parent_table."' and child_table = '".$child_table."' and relation_type = '".$relation_type."' and table_name = '".$table_name."' order by field_order" ;

        $result = pg_exec($db, $sql);

        $numrows = pg_numrows($result);
if ($numrows > 0) {
        while ($row = pg_fetch_array($result,$rownum))
        {
        if ($rownum == 0) {
                $sqlreq = $row[pg_fieldname($result,0)];
        } else {
                $sqlreq.= ",".$row[pg_fieldname($result,0)];
        }
        $rownum = $rownum + 1;
        }
} else {
	$sqlreq = "*";
}


return $sqlreq;
};



/* ======== function preface_return_fields ======= */
function preface_return_fields ($db, $incoming_fields, $tablename, $pre_value) {

if ($incoming_fields == " * ") {
        $sql = retrieve_column_list ($tablename);
        $result = pg_exec($db, $sql);

        while ($row = pg_fetch_array($result,$rownum))
                {

                if ($rownum == 0) {
                        $incoming_fields=$row[pg_fieldname($result,0)];
                } else {
                        $incoming_fields.=",".$row[pg_fieldname($result,0)];
                }
                $rownum = $rownum + 1;
                }

}
        $arr = split(",",$incoming_fields);

$num_elements = count ($arr);

for ($idx = 0; $idx < $num_elements; ++$idx) {

        if ($idx == 0) {

                $sqlreq.=$pre_value.$arr[$idx];
        } else {
                $sqlreq.=",".$pre_value.$arr[$idx];
        }

}

return $sqlreq;
};



/* ======== function get_table_field_access ======= */
function get_table_field_access ($db, $table_name, $acc_method) {

$sql = "select field_name from table_field_access where access_type='".$acc_method."' and table_name = '".$table_name."' order by sort_order" ;

        $result = pg_exec($db, $sql);

        $numrows = pg_numrows($result);

        if ($numrows == 0) {
                $sqlreq = " * ";
        } else {

                while ($row = pg_fetch_array($result,$rownum))
                {
                        if ($rownum == 0) {
                                $sqlreq = $row[pg_fieldname($result,0)];
                        } else {
                                $sqlreq.= ",".$row[pg_fieldname($result,0)];
                        }
                $rownum = $rownum + 1;
                }
        }

return $sqlreq;
};


/* ======== function count_table_field_access ======= */
function count_table_field_access ($db, $table_name, $whereclause) {

$sql = "select count(*) as ret_count from table_field_access ".$whereclause ;

        $result = pg_exec($db, $sql);

        $numrows = pg_numrows($result);

        if ($numrows == 0) {
                $sqlreq = 0;
        } else {
		list($sqlreq) = pg_fetch_row($result, 0);
        }

return $sqlreq;
};

/* == function retrieve_table_field_access_columns == */
function retrieve_table_field_access_columns ($str) {

$sqlreq="SELECT c.relname, a.attname, a.attnum, a.attlen, a.atttypmod, a.attnotnull, t.typname ";
$sqlreq.="FROM pg_attribute a left outer join table_field_access f on (cast(a.attname as varchar) = f.field_name  and f.table_name = '".$str."'), ";
$sqlreq.="pg_class c, pg_type t ";
$sqlreq.="WHERE a.attrelid = c.oid and a.attnum > 0 and ";
$sqlreq.="a.atttypid = t.oid and ";
$sqlreq.="c.relname = '".$str."' ";
$sqlreq.=" order by 1, 3";

return $sqlreq;
};


/* == function ret_base_32 == */
function ret_base_32 ($str) {

$b32_array = array('0','1','2','3','4','5','6','7','8','9','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W');

$retcode = $b32_array[$str];

return $retcode;
};

/* == function ret_base_64 == */
function ret_base_64 ($str) {

/* $b64_array = array('0','1','2','3','4','5','6','7','8','9','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','_',' '); */
$b64_array = array('0','1','2','3','4','5','6','7','8','9','a','A','b','B','c','C','d','D','e','E','f','F','g','G','h','H','i','I','j','J','k','K','l','L','m','M','n','N','o','O','p','P','q','Q','r','R','s','S','t','T','u','U','v','V','w','W','x','X','y','Y','z','Z','_',' ');

$retcode = $b64_array[$str];

return $retcode;
};

/* == function decode_base_32 == */
function decode_base_32 ($str) {

$b32_array = array('0','1','2','3','4','5','6','7','8','9','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W');
$retcode = 0;
for ($idx = 0; $idx < count($b32_array); ++$idx) {

        if ($str == $b32_array[$idx]) {
                $retcode = $idx;
                return $retcode;
                exit;
        }
}

$retcode = $b32_array[$str];

return $retcode;
};



/* == function decode_base_64 == */
function decode_base_64 ($str) {

$b64_array = array('0','1','2','3','4','5','6','7','8','9','a','A','b','B','c','C','d','D','e','E','f','F','g','G','h','H','i','I','j','J','k','K','l','L','m','M','n','N','o','O','p','P','q','Q','r','R','s','S','t','T','u','U','v','V','w','W','x','X','y','Y','z','Z','_',' ');
$retcode = 0;
for ($idx = 0; $idx < count($b64_array); ++$idx) {

	if ($str == $b64_array[$idx]) {
		$retcode = $idx;
		return $retcode;
		exit;
	}
}

$retcode = $b64_array[$str];

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


/* ======== function checkRespondent ======= */
function checkRespondent ($db, $issue_id, $issue_topic) {
$retcode = 0;
$sql = "select employee_id, respondent_cd from emp_resp where respondent_cd = (select respondent_cd from issue_topic where issue_topic = '".$issue_topic."')";

$result = pg_exec($db,$sql);

if(pg_ErrorMessage($db))
        {
        DisplayErrMsg(sprintf("Error in executing %s statement", $sql)) ;
        DisplayErrMsg(sprintf("Error: %s", pg_ErrorMessage($db))) ;
        };

$num_rows = pg_num_rows($result);
if ($num_rows == 1) {

	list ($employee_id) = pg_fetch_row($result, 0);



$sql = "insert into issue_owner VALUES ('".$issue_id."', '".$employee_id."',now(),'unknown')";
        $result = pg_exec($db, $sql);
if(pg_ErrorMessage($db))
        {
        DisplayErrMsg(sprintf("Error in executing %s statement", $sql)) ;
        DisplayErrMsg(sprintf("Error: %s", pg_ErrorMessage($db))) ;
        };

        $retcode = 1;
}

return $retcode;
};

/* ======== function showEcho ======= */
function showEcho ($echo_text, $echo_value) {
	echo "<p>".$echo_text.$echo_value."</p>";
}
/* ======== function createMessage ======= */
function createMessage ($db, $template_name, $notification_id) {

	$sql ="select * from notice_data WHERE notification_id ='".$notification_id."'" ;

	$result = pg_exec($db,$sql);

	if(pg_ErrorMessage($db))
        	{
        	DisplayErrMsg(sprintf("Error in executing %s statement", $sql)) ;
        	DisplayErrMsg(sprintf("Error: %s", pg_ErrorMessage($db))) ;
        	};

	$rownum = 0;

	while ($row = pg_fetch_array($result,$rownum)) {
	list($notice_cd, $notice_field[$rownum], $notice_field_value[$rownum]) = pg_fetch_row ($result, $rownum);

	$$notice_field[$rownum] = $notice_field_value[$rownum];

	$rownum = $rownum+1;
	}

	include ($template_name);

	return $message;
}


/* ======== function returnRespondentArray ======= */
function return_RespondentArray ($db, $issue_topic) {

	$sql ="select DISTINCT er.employee_id, e.first_name||' '||e.last_name FROM emp_resp er, ";
	$sql.=" employee e WHERE er.employee_id = e.employee_id AND er.respondent_cd IN (SELECT DISTINCT respondent_cd FROM issue_topic WHERE issue_topic like '".$issue_topic."') AND e.employee_type = 'respondent'";

	$result = pg_exec($db,$sql);

	if(pg_ErrorMessage($db))
        	{
        	DisplayErrMsg(sprintf("Error in executing %s statement", $sql)) ;
        	DisplayErrMsg(sprintf("Error: %s", pg_ErrorMessage($db))) ;
        	};

	$rownum = 0;
	while ($row = pg_fetch_array($result,$rownum)) {
	list($emp_id, $emp_fullname) = pg_fetch_row ($result, $rownum);

	$respArray[$rownum][0]=$emp_id;
	$respArray[$rownum][1]=$emp_fullname; 

	$rownum = $rownum+1;
	}

return $respArray;

}

/* ======== function encryptData ======= */
function encryptData ($key, $in_data) {

    $CYPHER = MCRYPT_RIJNDAEL_256;
    $MODE   = MCRYPT_MODE_CBC;


        $td = mcrypt_module_open($CYPHER, '', $MODE, '');
        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        mcrypt_generic_init($td, $key, $iv);
        $crypttext = mcrypt_generic($td, $in_data);
        mcrypt_generic_deinit($td);
#        return base64_encode($iv.$crypttext);


	$plain_text = base64_encode($crypttext);

	return $plain_text."SEPARATOR".$iv;
}

/* ======== function encryptData ======= */
function encryptData_new ($key, $plaintext) {

    $CYPHER = MCRYPT_RIJNDAEL_256;
    $MODE   = MCRYPT_MODE_CBC;

    $td = mcrypt_module_open($CYPHER, '', $MODE, '');
    $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
    mcrypt_generic_init($td, $key, $iv);
    $crypttext = mcrypt_generic($td, $plaintext);
    mcrypt_generic_deinit($td);
    return base64_encode($iv.$crypttext);

}

/* ======== function encryptData ======= */
function encryptData_old ($key, $in_data) {

#$alg = MCRYPT_CAST_256;
#$mode = MCRYPT_MODE_CFB;
$mode = MCRYPT_MODE_CBC;
$alg = MCRYPT_BLOWFISH;

$iv = mcrypt_create_iv(mcrypt_get_iv_size($alg,$mode),MCRYPT_DEV_URANDOM);
$encrypted_data = mcrypt_encrypt($alg, $key, $in_data, $mode, $iv);
$plain_text = base64_encode($encrypted_data);

return $plain_text."SEPARATOR".$iv;
}

/* ======== function unencryptData ======= */
function unencryptData ($key, $in_data, $in_iv) {

    $CYPHER = MCRYPT_RIJNDAEL_256;
    $MODE   = MCRYPT_MODE_CBC;


        $crypttext = base64_decode($in_data);
        $plaintext = '';
        $td        = mcrypt_module_open($CYPHER, '', $MODE, '');
        $ivsize    = mcrypt_enc_get_iv_size($td);
//        $iv        = substr($crypttext, 0, $ivsize);
        $crypttext = substr($crypttext, $ivsize);
        if ($iv)
        {
            mcrypt_generic_init($key, $iv);
            $plaintext = mdecrypt_generic($td, $crypttext);
        }
        return trim($plaintext);





// $decoded = mcrypt_decrypt($alg,$key,base64_decode($in_data),$mode,$in_iv);
// return $decoded;
}

function unencryptData_new($key, $crypttext) {

    $CYPHER = MCRYPT_RIJNDAEL_256;
    $MODE   = MCRYPT_MODE_CBC;

        $crypttext = base64_decode($crypttext);
        $plaintext = '';
        $td        = mcrypt_module_open($CYPHER, '', $MODE, '');
        $ivsize    = mcrypt_enc_get_iv_size($td);
        $iv        = substr($crypttext, 0, $ivsize);
        $crypttext = substr($crypttext, $ivsize);
        if ($iv)
        {
            mcrypt_generic_init($td, $key, $iv);
            $plaintext = mdecrypt_generic($td, $crypttext);
        }
        return trim($plaintext);
}




/* ======== function unencryptData ======= */
function unencryptData_old ($key, $in_data, $in_iv) {

$alg = MCRYPT_BLOWFISH;
$mode = MCRYPT_MODE_CBC;

$decoded = mcrypt_decrypt($alg,$key,base64_decode($in_data),$mode,$in_iv);
return $decoded;
}

/* ======== function encryptHref ======= */

function encryptHref ($sid, $in_data) {

$encrypted_data = $in_data;
/*
 $td = mcrypt_module_open('tripledes', '', 'ecb', '');
 $iv = mcrypt_create_iv (mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
 mcrypt_generic_init($td, $key, $iv);
 $encrypted_data = mcrypt_generic($td, $input);
 mcrypt_generic_deinit($td);
 mcrypt_module_close($td);
*/
 $encrypted_data = compressCrypt($encrypted_data);
 return $encrypted_data;
}


function unencryptHref ($sid, $in_data) {
    $encrypted_text = decompressCrypt($in_data);
    $decrypted_text = $encrypted_text;
/*    $decrypted_text = mcrypt_ecb(MCRYPT_DES, $sid, $encrypted_text , MCRYPT_DECRYPT); */
    return $decrypted_text;
}

function old_encryptHref ($sid, $in_data) {
/*    $encrypted_text = mcrypt_ecb(MCRYPT_DES, $sid, $in_data, MCRYPT_ENCRYPT); 
    $encrypted_text = compressCrypt($encrypted_text);  
    $encrypted_text = compressCrypt($in_data);  */

 $key = $sid; 
 $input = $in_data; 

 $td = mcrypt_module_open('tripledes', '', 'ecb', '');
 $iv = mcrypt_create_iv (mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
 mcrypt_generic_init($td, $key, $iv);
 $encrypted_data = mcrypt_generic($td, $input);
 mcrypt_generic_deinit($td);
 mcrypt_module_close($td);




    $encrypted_text = compressCrypt($encrypted_data); 
    return $encrypted_text;
}

/* ======== function unencryptHref ======= */
function old_unencryptHref ($sid, $in_data) {
    $encrypted_text = decompressCrypt($in_data);
    $decrypted_text = mcrypt_ecb(MCRYPT_DES, $sid, $encrypted_text , MCRYPT_DECRYPT);
    return $decrypted_text;
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

/* ======== function newNotification ======= */
function newNotification($db, $not_code, $email, $debug) {

        $sql = "SELECT to_char(now(),'YYMMDDHHMISSMS') as key_val, notice_subject, notice_text, notice_default_group_cd, notice_template, notice_level, now() FROM notice_code WHERE notice_cd = '".$not_code."'";
        $result = execSql($db,$sql,$debug);

	$numrows = pg_num_rows($result);

if ($numrows == 1) {

        list ($key_val, $notice_subject, $notice_text, $notice_default_group_cd, $notice_template, $notice_level, $post_timestamp ) = pg_fetch_row($result, 0);

        $sql = "INSERT into notification (
        notification_id,
        notice_cd,
        notice_group_cd,
        notice_subject,
        notice_text,
        notice_level,
        post_timestamp,
        notice_email,
        notice_template) values
        ('".$key_val."','"
        .$not_code."','"
        .$notice_default_group_cd."','"
        .$notice_subject."','"
        .$notice_text."','"
        .$notice_level."','"
        .$post_timestamp."','"
        .$email."','"
        .$notice_template."')";

        $result = execSql($db,$sql, $debug);

} else {

	$key_val = 'error';
}


return $key_val;
}

/* ======== function newNotice_data ======= */
function newNotice_Data($db, $key_val, $field_value, $field_data_value, $debug) {

        $sql = "INSERT into notice_data values ('".$key_val."','".$field_value."','".$field_data_value."')";
        $result = execSql($db,$sql, $debug);

	return 1;
}

/* ======== function newNotice_Text ======= */
function newNotice_Text($db, $key_val, $notice_text, $debug) {

        $sql = "INSERT into notice_text values ('".$key_val."','".$notice_text."')";
        $result = execSql($db,$sql, $debug);

	return 1;
}

/* ======== function newNotice_Attach ======= */
function newNotice_Attach($db, $key_val, $attach_no, $notice_attach, $debug) {

        $sql = "INSERT into notification_attach values ('".$key_val."',".$attach_no.",'".$notice_attach."',null)";
        $result = execSql($db,$sql, $debug);

	return 1;
}
/* ========== function paylogWrite ========== */
function paylogWrite($temp_xa_id,$next_pay_seq,$raddr,$cashier_id,$cash_drawer_id,$out_account_type,$out_account_id,$out_bill_id,$PAYFLD0,$xa_post_date,$pay_bill_amount,$status) { 

        $outfile = fopen("/home/hpdata/paylog".(date('Ymd')),"a+") ;

        $outputline= $temp_xa_id.",".$next_pay_seq.",".$raddr.",".$cashier_id.",".$cash_drawer_id.",".$out_account_type.",".$out_account_id.",".$out_bill_id.",".$PAYFLD0.",".$xa_post_date.",".$pay_bill_amount.",".$status;

        fputs($outfile,$outputline);
        fputs($outfile,"\n");
        fclose($outfile);


}


/* ========== function auth_transaction ========== */
function auth_transaction($db, $output_transaction, $debug) {
// output url - i.e. the absolute url to the paymentsgateway.net script
$output_url = "https://www.paymentsgateway.net/cgi-bin/posttest.pl";
// Uncomment below for live
//$output_url = "https://www.paymentsgateway.net/cgi-bin/postauth.pl";
// echo "output transaction = ".$output_transaction."<br />";

// start output buffer to catch curl return data
ob_start();

        // setup curl
                $ch = curl_init ($output_url);
        // set curl to use verbose output
                curl_setopt ($ch, CURLOPT_VERBOSE, 1);
        // set curl to use HTTP POST
                curl_setopt ($ch, CURLOPT_POST, 1);
        // set POST output
                curl_setopt ($ch, CURLOPT_POSTFIELDS, $output_transaction);
        //execute curl and return result to STDOUT
                curl_exec ($ch);
        //close curl connection
                curl_close ($ch);

// set variable eq to output buffer
$process_result = ob_get_contents();

// close and clean output buffer
ob_end_clean();

// clean response data of whitespace, convert newline to ampersand for parse_str function and trim off endofdata
$clean_data = str_replace("\n","&",trim(str_replace("endofdata", "", trim($process_result))));

// parse the string into variablename=variabledata
parse_str($clean_data);

// output some of the variables
/*
echo "Response Type = ".$pg_response_type."<br />";
echo "Response Code = ".$pg_response_code."<br />";
echo "Response Description = ".$pg_response_description."<br />";

echo "<br>stuff<br>";
print_r($clean_data);
*/
$response_sql = "INSERT INTO xa_pay_response_log (
                pay_seq,
                response_timestamp,
                response_code,
                response_subcode,
                transaction_id,
                description,
                method,
                transaction_type,
		merchant_setup_id ";

$response_sql_values = " VALUES (".
                $pg_merchant_data_2.",
                now(),'".
                $pg_response_type."','".
                $pg_response_code."','".
                $pg_trace_number."','".
                $pg_response_description."','".
                $pg_merchant_data_1."','".
                $pg_transaction_type."','".
                $pg_merchant_data_3."'";

if ($ecom_consumerorderid) {
        $response_sql.=", xa_id";
        $xa_data = explode('-',$ecom_consumerorderid);
        $response_sql_values.=",'".$xa_data[1]."'";
        /* $response_sql_values.=",'".$ecom_consumerorderid."'"; */
}
if ($pg_merchant_data_9) {
        $response_sql.=", xa_id";
        $response_sql_values.=",'".$pg_merchant_data_9."'";
}
if ($pg_authorization_code) {
        $response_sql.=", approval_code";
        $response_sql_values.=",'".$pg_authorization_code."'";
}
if ($pg_avs_result) {
        $response_sql.=", avs_method";
        $response_sql_values.=",'".$pg_avs_result."'";
}
if ($pg_avs_method) {
        $response_sql.=", avs_method";
        $response_sql_values.=",'".$pg_avs_method."'";
}
if ($pg_total_amount) {
        $response_sql.=", amount";
        $response_sql_values.=",".$pg_total_amount;
}
if ($ecom_billto_postal_name_first) {
        $response_sql.=", first_name";
        $response_sql_values.=",'".(addslashes($ecom_billto_postal_name_first))."'";
}
if ($ecom_billto_postal_name_last) {
        $response_sql.=", last_name";
        $response_sql_values.=",'".(addslashes($ecom_billto_postal_name_last))."'";
}
if ($pg_mail_or_phone_order) {
        $response_sql.=", mail_or_phone_order";
        $response_sql_values.=",'".$pg_mail_or_phone_order."'";
}
if ($pg_billto_postal_name_company) {
        $response_sql.=", company";
        $response_sql_values.=",'".(addslashes($pg_billto_postal_name_company))."'";
}
if ($ecom_billto_postal_street_line1) {
        $response_sql.=", billing_address";
        $response_sql_values.=",'".$ecom_billto_postal_street_line1."'";
}
if ($ecom_billto_postal_city) {
        $response_sql.=", city";
        $response_sql_values.=",'".$ecom_billto_postal_city."'";
}
if ($ecom_billto_postal_stateprov) {
        $response_sql.=", state";
        $response_sql_values.=",'".$ecom_billto_postal_stateprov."'";
}
if ($ecom_billto_postal_postalcode) {
        $response_sql.=", zip_code";
        $response_sql_values.=",'".$ecom_billto_postal_postalcode."'";
}
if ($ecom_billto_postal_country) {
        $response_sql.=", country";
        $response_sql_values.=",'".$ecom_billto_postal_country."'";
}
if ($ecom_billto_telecom_phone_number) {
        $response_sql.=", phone";
        $response_sql_values.=",'".$ecom_billto_telecom_phone_number."'";
}
if ($ecom_billto_telecom_online_email) {
        $response_sql.=", email";
        $response_sql_values.=",'".$ecom_billto_online_email."'";
}
if ($pg_customer_ip_address) {
        $response_sql.=", customer_ip_address";
        $response_sql_values.=",'".$pg_customer_ip_address."'";
}

$response_sql.= ") ".$response_sql_values.")";

$ret_code = execSql($db, $response_sql, $debug);

if ($ret_code != 'error') {
        $ret_val = $pg_response_type.','.$pg_response_code.','.$pg_response_description;
} else {
        $ret_val = $ret_code;
}

return $ret_val;

}



/* ========== function gen_trans_id ========== */
function gen_trans_id($db, $debug) {

$sql = "SELECT  to_char(cast(EXTRACT(milliseconds FROM TIMESTAMP 'NOW()') as integer),'00000') as micro, now() as tstamp, extract(doy from timestamp 'now()') as doy, extract(hour from timestamp 'now()') as hh, cast(to_char(now(), 'MI') as integer) as themin, cast(to_char(now(), 'YY') as integer) as yy, cast(to_char(now(),'MM') as integer) as themonth, cast(to_char(now(),'DD') as integer) as theday";

$result = execSql($db,$sql,$debug);

list($micro, $tstamp, $doy, $chour, $cminute, $cyear, $cmonth, $cday) = pg_fetch_row($result, 0);
$current_year = ret_base_64($cyear) ;

$current_month = ret_base_32($cmonth) ;
$current_day = ret_base_32($cday) ;
$current_hour = ret_base_64($chour) ;
$current_minute = ret_base_64($cminute) ;

$cust_trans_id = $current_year.$current_month.$current_day.$current_hour.$current_minute.$micro;
$cust_trans_id = ereg_replace(" ","",$cust_trans_id);


return $cust_trans_id;
}

/* ========== function gen_ymd32 ========== */
function gen_ymd32($db, $debug) {

$sql = "SELECT  to_char(cast(EXTRACT(milliseconds FROM TIMESTAMP 'NOW()') as integer),'00000') as micro, now() as tstamp, extract(doy from timestamp 'now()') as doy, extract(hour from timestamp 'now()') as hh, cast(to_char(now(), 'MI') as integer) as themin, cast(to_char(now(), 'YY') as integer) as yy, cast(to_char(now(),'MM') as integer) as themonth, cast(to_char(now(),'DD') as integer) as theday";

$result = execSql($db,$sql,$debug);

list($micro, $tstamp, $doy, $chour, $cminute, $cyear, $cmonth, $cday) = pg_fetch_row($result, 0);
$current_year = ret_base_32($cyear) ;
$current_month = ret_base_32($cmonth) ;
$current_day = ret_base_32($cday) ;

$ymd32 = $current_year.$current_month.$current_day;
$ymd32 = ereg_replace(" ","",$ymd32);


return $ymd32;
}

/* ========== function code_ymd32 ========== */
function code_ymd32($db, $inp_date, $debug) {

$current_year = ret_base_32((substr($inp_date,2,2) + 0)) ;
$current_month = ret_base_32((substr($inp_date,4,2) + 0)) ;
$current_day = ret_base_32((substr($inp_date,6,2) + 0)) ;

$ymd32 = $current_year.$current_month.$current_day;
$ymd32 = ereg_replace(" ","",$ymd32);


return $ymd32;  
}



/* ========== function test_transaction ========== */
function test_transaction($db, $output_transaction, $debug) {

/* $fp = fsockopen("ssl://www.paymentsgateway.net", "5051", $errno, $errstr, $timeout = 3);   */
 $fp = fsockopen("ssl://www.paymentsgateway.net", "6051", $errno, $errstr, $timeout = 3);   
/* remember 5051 is live 6051 is test */
/* $fp = fsockopen("ssl://www.paymentsgateway.net/cgi-bin/posttest.pl", "6051", $errno, $errstr, $timeout = 30); */

if(!$fp){ 
 //error tell us 
	$retval = 'error';
   
}else{ 

  //send the server request 
//  fputs($fp, "POST $path HTTP/1.1\r\n"); 
//  fputs($fp, "Host: $host\r\n"); 
//  fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n"); 
//  fputs($fp, "Content-length: ".strlen($poststring)."\r\n"); 
//  fputs($fp, "Connection: close\r\n\r\n"); 
//  fputs($fp, $poststring . "\r\n\r\n"); 
  fputs($fp, $output_transaction . "\r\n"); 

  //loop through the response from the server 
  while(!feof($fp)) { 
   $process_result = fgets($fp, 4096);
  } 
  //close fp - we are done with it 
  fclose($fp); 
} 


$clean_data = str_replace("\n","&",trim(str_replace("endofdata", "", trim($process_result))));

// parse the string into variablename=variabledata
parse_str($clean_data);

// output some of the variables
/*
echo "Response Type = ".$pg_response_type."<br />";
echo "Response Code = ".$pg_response_code."<br />";
echo "Response Description = ".$pg_response_description."<br />";

echo "<br>stuff<br>";
print_r($clean_data);
*/
$response_sql = "INSERT INTO xa_pay_response_log (
                pay_seq,
                response_timestamp,
                response_code,
                response_subcode,
                transaction_id,
                description,
                method,
                transaction_type,
                merchant_setup_id ";

$response_sql_values = " VALUES (".
                $pg_merchant_data_2.",
                now(),'".
                $pg_response_type."','".
                $pg_response_code."','".
                $pg_trace_number."','".
                $pg_response_description."','".
                $pg_merchant_data_1."','".
                $pg_transaction_type."','".
                $pg_merchant_data_3."'";

if ($ecom_consumerorderid) {
        $response_sql.=", xa_id";
        $xa_data = explode('-',$ecom_consumerorderid);
        $response_sql_values.=",'".$xa_data[1]."'";
        /* $response_sql_values.=",'".$ecom_consumerorderid."'"; */
}
if ($pg_merchant_data_9) {
        $response_sql.=", xa_id";
        $response_sql_values.=",'".$pg_merchant_data_9."'";
}
if ($pg_authorization_code) {
        $response_sql.=", approval_code";
        $response_sql_values.=",'".$pg_authorization_code."'";
}
if ($pg_avs_result) {
        $response_sql.=", avs_method";
        $response_sql_values.=",'".$pg_avs_result."'";
}
if ($pg_avs_method) {
        $response_sql.=", avs_method";
        $response_sql_values.=",'".$pg_avs_method."'";
}
if ($pg_total_amount) {
        $response_sql.=", amount";
        $response_sql_values.=",".$pg_total_amount;
}
if ($ecom_billto_postal_name_first) {
        $response_sql.=", first_name";
        $response_sql_values.=",'".(addslashes($ecom_billto_postal_name_first))."'";
}
if ($ecom_billto_postal_name_last) {
        $response_sql.=", last_name";
        $response_sql_values.=",'".(addslashes($ecom_billto_postal_name_last))."'";
}
if ($pg_mail_or_phone_order) {
        $response_sql.=", mail_or_phone_order";
        $response_sql_values.=",'".$pg_mail_or_phone_order."'";
}
if ($pg_billto_postal_name_company) {
        $response_sql.=", company";
        $response_sql_values.=",'".(addslashes($pg_billto_postal_name_company))."'";
}
if ($ecom_billto_postal_street_line1) {
        $response_sql.=", billing_address";
        $response_sql_values.=",'".$ecom_billto_postal_street_line1."'";
}
if ($ecom_billto_postal_city) {
        $response_sql.=", city";
        $response_sql_values.=",'".$ecom_billto_postal_city."'";
}
if ($ecom_billto_postal_stateprov) {
        $response_sql.=", state";
        $response_sql_values.=",'".$ecom_billto_postal_stateprov."'";
}
if ($ecom_billto_postal_postalcode) {
        $response_sql.=", zip_code";
        $response_sql_values.=",'".$ecom_billto_postal_postalcode."'";
}
if ($ecom_billto_postal_country) {
        $response_sql.=", country";
        $response_sql_values.=",'".$ecom_billto_postal_country."'";
}
if ($ecom_billto_telecom_phone_number) {
        $response_sql.=", phone";
        $response_sql_values.=",'".$ecom_billto_telecom_phone_number."'";
}
if ($ecom_billto_telecom_online_email) {
        $response_sql.=", email";
        $response_sql_values.=",'".$ecom_billto_online_email."'";
}
if ($pg_customer_ip_address) {
        $response_sql.=", customer_ip_address";
        $response_sql_values.=",'".$pg_customer_ip_address."'";
}

$response_sql.= ") ".$response_sql_values.")";

$ret_code = execSql($db, $response_sql, $debug);

if ($ret_code != 'error') {
        $ret_val = $pg_response_type.','.$pg_response_code.','.$pg_response_description;
} else {
        $ret_val = $ret_code;
        /* $ret_val = $ret_code.",Error adding to response log - please reenter"; */
}

return $ret_val;

}



/* ======== function validateAbacode ======= */
function validateAbacode($db, $aba_code, $acct_num, $pay_method) {

	$sql= "SELECT count(*) FROM non_participate_aba_code WHERE bank_aba_code = '".$aba_code."' AND (bank_acct_num = 'ALL' or bank_acct_num = '".$acct_num."')";

	$result = pg_exec($db, $sql);

	list($non_part_count) = pg_fetch_row($result,0);

	if ($non_part_count >  0) {
		$pay_method = 'MCHECK';
	}

return $pay_method; 
}


/* ======== function getLastTransId ======= */
function getLastTransId($db, $cashier_id) {

        $sql = "SELECT xa_id FROM xa_log where cashier_id = '".$cashier_id."' order by xa_timestamp desc limit 1";
        $result = execSql($db,$sql,$debug);
        list ($last_xa_id) = pg_fetch_row($result,0);

return $last_xa_id;
}

function compressCrypt($string) {
         return base64_encode($string);
/*        return base64_encode(gzcompress($string, 9)); */
}

function decompressCrypt($string) {
/*
$uncompressed = gzuncompress($string);
echo "uncompressed is ".$uncompressed."<br><br>";
*/


/*        return gzuncompress(base64_decode($string));  */
        return base64_decode($string);
}



?>
