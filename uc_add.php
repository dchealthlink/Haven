<?php
session_start();
include("inc/dbconnect.php");

if ($formmenu) {
  	header("location: uc_menu.php");
	exit;
}

if ($formcopy) {
                $nextsql = "select  '".$_POST['projectId']."'||'-'||lpad(coalesce(max(usecasenum) + 1,1),4,'0') as nextnum, coalesce(max(usecasenum) + 1,1) as thenumber FROM use_case WHERE projectid = '".$projectId."'";
                $nextresult = execSql($db, $nextsql, $debug);
                list($ucId, $ucNumber) = pg_fetch_row($nextresult,0);

		$sql = "insert into use_case (usecaseid, usecaseversion, usecasename, goalincontext,  narrative , scope , successcondition , failcondition , trigger , priority , performance , frequency, owner, statustimestamp, created_by, uc_tier, projectid, usecasenum ) values ('".$ucId."','".$_POST['usecaseVersion']."','copy of '||upper('".addslashes($_POST['usecaseName'])."'),'".addslashes($_POST['goalInContext'])."', '".addslashes($_POST['narrative'])."','".$_POST['scope']."','".addslashes($_POST['successCondition'])."','".addslashes($_POST['failCondition'])."',   '".addslashes($_POST['trigger'])."','".$_POST['priority']."','".$_POST['performance']."','".$_POST['frequency']."', '".$_SESSION['userid']."',   now(), '".$_SESSION['userid']."','".$_POST['ucTier']."','".$_POST['projectId']."' ,".$ucNumber.")";

                $sql = str_replace("''","null",$sql);
                $sql = str_replace("'null'","null",$sql);
                $result = execSql($db,$sql,$debug) ;

}


if ($formsubmit) {

	$presql = "SELECT count(*) from use_case WHERE usecaseid = '".$_POST['usecaseId']."'";
	$preresult = execSql($db,$presql,$debug) ;
	list($precount) = pg_fetch_row($preresult,0);

	if ($precount == 0) {


		$nextsql = "select  '".$_POST['projectId']."'||'-'||lpad(coalesce(max(usecasenum) + 1,1),4,'0') as nextnum, coalesce(max(usecasenum) + 1,1) as thenumber FROM use_case WHERE projectid = '".$_POST['projectId']."'";

		$nextresult = execSql($db, $nextsql, $debug);
		list($ucId,$ucNumber) = pg_fetch_row($nextresult,0);

		$sql = "insert into use_case (usecaseid , usecaseversion , usecasename , goalincontext , narrative , scope , successcondition , failcondition , trigger , priority , performance , frequency, owner, statustimestamp, created_by, uc_tier, projectid, usecasenum ) values ('".$ucId."','".$_POST['usecaseVersion']."',upper('".addslashes($_POST['usecaseName'])."'),'".addslashes($_POST['goalInContext'])."', '".addslashes($_POST['narrative'])."','".$_POST['scope']."','".addslashes($_POST['successCondition'])."','".addslashes($_POST['failCondition'])."',   '".addslashes($_POST['trigger'])."','".$_POST['priority']."','".$_POST['performance']."','".$_POST['frequency']."', '".$_SESSION['userid']."',   now(), '".$_SESSION['userid']."','".$_POST['ucTier']."','".$_POST['projectId']."',".$ucNumber."  ) ";

	} else {
		$ucId = $_POST['usecaseId'];
		$sql = "UPDATE use_case set ";
		$sql.= "usecaseversion   = '".$_POST['usecaseVersion']."', ";
		$sql.= "usecasename   = upper('".$_POST['usecaseName']."'), ";
		$sql.= "goalincontext   = '".$_POST['goalInContext']."', ";
		$sql.= "narrative   = '".$_POST['narrative']."', ";
		$sql.= "scope   = '".$_POST['scope']."', ";
		$sql.= "successcondition   = '".$_POST['successCondition']."', ";
		$sql.= "failcondition   = '".$_POST['failCondition']."', ";
		$sql.= "trigger   = '".$_POST['trigger']."', ";
		$sql.= "priority   = '".$_POST['priority']."', ";
		$sql.= "performance   = '".$_POST['performance']."', ";
		$sql.= "frequency   = '".$_POST['frequency']."', ";
		$sql.= "owner   = '".$_SESSION['userid']."', ";
		$sql.= "uc_tier   = '".$_POST['ucTier']."', ";
		$sql.= "projectid   = '".$_POST['projectId']."', ";
		$sql.= "statustimestamp   = now() WHERE usecaseid = '".$usecaseId."'  and (";
		$sql.= "usecaseversion   != '".$_POST['usecaseVersion']."' OR ";
		$sql.= "usecasename   != upper('".$_POST['usecaseName']."') OR ";
		$sql.= "goalincontext   != '".$_POST['goalInContext']."' OR ";
		if ($_POST['narrative']) {
			$sql.= "narrative   = '".$_POST['narrative']."' OR ";
		}
		if ($_POST['scope']) {
			$sql.= "scope   = '".$_POST['scope']."' OR ";
		}
		if ($_POST['failCondition']) {
			$sql.= "failcondition   = '".$_POST['failCondition']."' OR ";
		}
		if ($_POST['trigger']) {
			$sql.= "trigger   = '".$_POST['trigger']."' OR ";
		}
		if ($_POST['priority']) {
			$sql.= "priority   = '".$_POST['priority']."' OR ";
		}
		if ($_POST['performance']) {
			$sql.= "performance   = '".$_POST['performance']."' OR ";
		}
		if ($_POST['frequency']) {
			$sql.= "frequency   = '".$_POST['frequency']."' OR  ";
		}
		$sql.= "successcondition   = '".$_POST['successCondition']."' ) ";
	}

		$sql = str_replace("''","null",$sql);
		$sql = str_replace("'null'","null",$sql);
		$result = execSql($db,$sql,$debug) ;


	if ($_POST['actionType']) {
			$presql = "SELECT max(action_inc) + 1 FROM use_case_action WHERE usecaseid = '".$ucId."' AND action_type = '".$_POST['actionType']."' ";
			$preresult = execSql($db,$presql,$debug) ;
			list ($nextval) = pg_fetch_row($preresult,0) ;
			$nextval = $nextval ? $nextval : 1;

		switch ($_POST['actionType']) {

		case 'actor':
			$sql = "INSERT INTO use_case_action (usecaseid, action_type, action_inc, actor, owner, statustimestamp) values ('".$ucId."','".$_POST['actionType']."','".$nextval."','".$_POST['actor']."','".$_SESSION['userid']."', now() ) ";
		break;

		case 'scenario':
		case 'exception':
		case 'extention':
		case 'open':
		case 'precondition':
		case 'schedule':
		case 'variation':
			$sql = "INSERT INTO use_case_action (usecaseid, action_type, action_inc, action_step, action_value, actor, owner, statustimestamp) values ('".$ucId."','".$_POST['actionType']."','".$nextval."','".$_POST['stepNo']."','".$_POST['nextStep']."','".$_POST['actor']."','".$_SESSION['userid']."', now() ) ";
		break;
		case 'superordinate':
			$presql = "SELECT max(action_inc) + 1 FROM use_case_action WHERE usecaseid = '".$_POST['actionUseCase']."' AND action_type = 'subordinate' ";
			$preresult = execSql($db,$presql,$debug) ;
			list ($nextval) = pg_fetch_row($preresult,0) ;
			$nextval = $nextval ? $nextval : 1;
			$sql = "INSERT INTO use_case_action (usecaseid, action_type, action_inc, action_step, action_value, actor, owner, statustimestamp) values ('".$_POST['actionUseCase']."','subordinate','".$nextval."','".$nextval."','".$ucId."','".$_POST['actor']."','".$_SESSION['userid']."', now() ) ";
		break;
		case 'subordinate':
			$sql = "INSERT INTO use_case_action (usecaseid, action_type, action_inc, action_step, action_value, actor, owner, statustimestamp) values ('".$ucId."','subordinate','".$nextval."','".$nextval."','".$_POST['actionUseCase']."','".$_POST['actor']."','".$_SESSION['userid']."', now() ) ";
		break;
		}
		$sql = str_replace("''","null",$sql);
		$result = execSql($db,$sql,$debug) ;

	}

}

 header("location: uc_form.php?ucId=".$ucId);






?>

