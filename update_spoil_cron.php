<?php
include("inc/dbconnect.php");


	$update_modulesql = "UPDATE module_user SET module_status = 'E' WHERE module_spoil_date < now()::date - 20 AND module_status in ('I','P','A') ";
//	$upd_mod_result = pg_exec($db, $update_modulesql);

	echo $update_modulesql ;
	$course_sql = "select cu.course_id, c.course_name, cu.user_id, e.first_name||' '||e.last_name as full_name, cu.course_spoil_date, cu.status, cu.course_spoil_date - now()::date as num_days FROM course_user cu, course c, employee e WHERE cu.course_id = c.course_id AND cu.user_id = e.employee_id and cu.status in ('I','P','A') order by 3,1,2";
	$course_result = pg_exec($db, $course_sql);
	$numrows = pg_num_rows($course_result) ;
	echo $course_sql ;

$lastweek = array();
$expired  = array();
$lw;
$expi;

$rownum = 0;
	while ($row = pg_fetch_array($course_result,$rownum)) {

        	list ($temp_cid, $temp_cname, $temp_uid, $temp_full_name, $temp_spoil_date, $temp_status, $temp_num_days) = pg_fetch_row($course_result,$rownum) ;

		if ($temp_num_days < 0) {
			$expi.= $temp_cid."\t".$temp_cname."\t".$temp_uid."\t".$temp_full_name."\t".$temp_spoil_date."\n";
			echo "expi -----> ".$expi."<br>";
			$expired[]  = array($temp_cid, $temp_cname, $temp_uid, $temp_full_name, $temp_spoil_date) ;
		} else {
			$lw.= $temp_cid."\t".$temp_cname."\t".$temp_uid."\t".$temp_full_name."\t".$temp_spoil_date."\n";
			echo "lw -----> ".$lw."<br>";
			$lastweek[] = array($temp_cid, $temp_cname, $temp_uid, $temp_full_name, $temp_spoil_date) ;
		}
	$rownum = $rownum + 1;
}


if ($numrows > 0) {

	        $sql = "SELECT to_char(now(),'YYMMDDHHMISSMS') as key_val, notice_subject, notice_text, notice_default_group_cd, notice_template, notice_level, now() FROM notice_code WHERE notice_cd = 'course_expire'";

        	$result = pg_exec($db,$sql);

        	list ($key_val, $notice_subject, $notice_text, $notice_default_group_cd, $notice_template, $notice_level, $post_timestamp ) = pg_fetch_row($result, 0);
        	$email = 'support@ignitetrx.com';

	        $errsql = "INSERT into notification (
	        notification_id,
        	notice_cd,
	        notice_group_cd,
        	notice_subject,
	        notice_text,
        	notice_level,
	        posting_process,
        	post_timestamp,
	        notice_email,
        	notice_template) values
	        ('".$key_val."','course_expire','"
        	.$notice_group_cd."','"
	        .$notice_subject."','"
        	.$notice_text."','"
	        .$notice_level."','Course Expire','"
        	.$post_timestamp."','"
	        .$email."','"
        	.$notice_template."')";

echo '<br><br>';
	echo $errsql;

echo '<br><br>';
	        $errresult = pg_exec($db,$errsql);

		$detsql = "INSERT INTO notice_data values ('".$key_val."','post_timestamp','now()')";
	        $detresult = pg_exec($db,$detsql);
		echo "<br><br>";
		$detsql = "INSERT INTO notice_data values ('".$key_val."','last_week',null,'".$lw."')";
	        $detresult = execSql($db,$detsql,$we);
		echo $detsql."<br><br>";
		$detsql = "INSERT INTO notice_data values ('".$key_val."','expired',null,'".$expi."')";
	        $detresult = pg_exec($db,$detsql);
		echo $detsql."<br><br>";



	}

echo '<br><br>';

print_r($expired) ;
echo '<br><br>';

echo $expi ;

echo '<br><br>';

print_r($lastweek) ;
echo '<br><br>';

echo $lw ;

// free memory
pg_free_result($result);
// close connection
pg_close($db);
?>
