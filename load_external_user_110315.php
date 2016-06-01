<?php
/*
session_start();
*/
include "inc/qdbconnect.php";
/* include("inc/header_inc.php"); */

$check_no = 0;
$recordid = 0;

$fnm = "extract35_externaluser_PRODa.csv";
$handle = fopen("/tmp/".$fnm, "r");
$badlog = fopen("/tmp/failed_bad_log.".(date("Ymd")), "w");

$goodcount = 0;
$badcount = 0;
if ($handle) {
   while (!feof($handle)) {
       $buffer = fgets($handle, 4096);
	$dummy = explode("|",$buffer);


	if ($dummy[7]) {

//	if (is_numeric($dummy[1]) AND is_numeric($dummy[15]) ) {
		$sql = "INSERT INTO externaluser_110315a  ";
//	} else {
//		$sql = "INSERT INTO activepolicy_glue_dc101015  ";
//	}

// USERNAME,ACCOUNTENABLED,APPLICATIONCODE,CREATIONDATE,TITLE,FIRSTNAME,SURNAME,FULLNAME,LASTSUCCESSLOGIN,LOGINDAYMON,LOGINDAYTUES,LOGINDAYWED,LOGINDAYTHURS,LOGINDAYFRI,LOGINDAYSAT,LOGINDAYSUN,LOGINFAILURES,LOGINRESTRICTIONS,LOGINTIMEFROM,LOGINTIMETO,LOGSSINCEPWDCHANGE,PASSWORD,PASSWORDCHANGED,PASSWORDEXPIRYDATE,PWDCHANGEAFTERXLOG,PWDCHANGEEVERYXDAY,ROLENAME,SENSITIVITY,STATUSCODE,DEFAULTLOCALE,TYPE,USERPREFSETID,UPPERUSERNAME,CREATEDBY,CREATEDON,LASTUPDATEDBY,LASTUPDATEDON,VERSIONNO


		$sql.= " (USERNAME,ACCOUNTENABLED,APPLICATIONCODE,CREATIONDATE,TITLE,FIRSTNAME,SURNAME,FULLNAME,LASTSUCCESSLOGIN, datasource, user_fullname) VALUES ( ";
		if ($dummy[0]) {
		$dummy[0] = str_replace("'","''",$dummy[0]) ;
		$sql.="'".trim($dummy[0])."',";
		} else {
		$sql.="null,";
		}
		if ($dummy[1]) {
		$dummy[1] = str_replace("'","''",$dummy[1]) ;
		$sql.="'".trim($dummy[1])."',";
		} else {
		$sql.="null,";
		}
		if ($dummy[2]) {
		$dummy[2] = str_replace("'","''",$dummy[2]) ;
		$sql.="'".trim($dummy[2])."',";
		} else {
		$sql.="null,";
		}
		if ($dummy[3]) {
		$sql.="'".trim($dummy[3])."',";
		} else {
		$sql.="null,";
		}
		if ($dummy[4]) {
		$sql.="'".trim($dummy[4])."',";
		} else {
		$sql.="null,";
		}
		if ($dummy[5]) {
		$dummy[5] = str_replace("'","''",$dummy[5]) ;
		$sql.="'".trim($dummy[5])."',";
		} else {
		$sql.="null,";
		}
		if ($dummy[6]) {
		$dummy[6] = str_replace("'","''",$dummy[6]) ;
		$sql.="'".trim($dummy[6])."',";
		} else {
		$sql.="null,";
		}
		if ($dummy[7]) {
		$dummy[7] = str_replace("'","''",$dummy[7]) ;
		$sql.="'".trim($dummy[7])."',";
		} else {
		$sql.="null,";
		}
		if ($dummy[8]) {
		$sql.="'".trim($dummy[8])."',";
		} else {
		$sql.="null,";
		}
		$sql.="'".$fnm."',upper('".$dummy[7]."') ) ;";
		}

		$recordid = $recordid + 1;

//		$sql = str_replace("'","''",$sql);
//		echo $sql."\n";
		$result = pg_exec($db,$sql); 
	if (is_resource($result)) {
		$goodcount = $goodcount + 1;
	} else {
		$badcount = $badcount + 1;
	 	fputs($badlog, "error - ".$sql."\n\n");
	}


/*		echo $sql."<br><br>"; */



   }
   fclose($badlog);
   fclose($handle);
}

echo "goodcount == ".$goodcount."   and badcount == ".$badcount;

?> 
