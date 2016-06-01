<?php 
/* == function ret_base_32 == */
function ret_base_32x ($str) {

$b32_array = array('0','1','2','3','4','5','6','7','8','9','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W');

$retcode = $b32_array[$str];

return $retcode;
};

/* == function ret_base_64 == */
function ret_base_64x ($str) {

/* $b64_array = array('0','1','2','3','4','5','6','7','8','9','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','_',' '); */
$b64_array = array('0','1','2','3','4','5','6','7','8','9','a','A','b','B','c','C','d','D','e','E','f','F','g','G','h','H','i','I','j','J','k','K','l','L','m','M','n','N','o','O','p','P','q','Q','r','R','s','S','t','T','u','U','v','V','w','W','x','X','y','Y','z','Z','_',' ');

$retcode = $b64_array[$str];

return $retcode;
};

/* == function decode_base_32 == */
function decode_base_32x ($str) {

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
function decode_base_64x ($str) {

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



/* ========== function gen_trans_id ========== */
function gen_trans_idx($db, $debug) {

$sql = "SELECT  to_char(cast(EXTRACT(milliseconds FROM TIMESTAMP 'NOW()') as integer),'00000') as micro, now() as tstamp, extract(doy from timestamp 'now()') as doy, extract(hour from timestamp 'now()') as hh, cast(to_char(now(), 'MI') as integer) as themin, cast(to_char(now(), 'YY') as integer) as yy, cast(to_char(now(),'MM') as integer) as themonth, cast(to_char(now(),'DD') as integer) as theday";

$result = pg_exec($db,$sql);

list($micro, $tstamp, $doy, $chour, $cminute, $cyear, $cmonth, $cday) = pg_fetch_row($result, 0);
$current_year = ret_base_64x($cyear) ;

$current_month = ret_base_32x($cmonth) ;
$current_day = ret_base_32x($cday) ;
$current_hour = ret_base_64x($chour) ;
$current_minute = ret_base_64x($cminute) ;

$cust_trans_id = $current_year.$current_month.$current_day.$current_hour.$current_minute.$micro;
$cust_trans_id = str_replace(" ","",$cust_trans_id);


return $cust_trans_id;
}
?>
