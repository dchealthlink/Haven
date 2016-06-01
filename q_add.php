<?php
session_start();
include("inc/dbconnect.php");

if ($formmenu) {
  	header("location: q_menu.php");
	exit;
}

if ($formsubmit) {

	if (!$_POST['questionId']) {

		$sql = "insert into question (question, subject, usecaseid, entered_by, entered_timestamp, projectid ) values ('".$_POST['question']."','".$_POST['subject']."',upper('".$_POST['usecaseId']."'), '".$_SESSION['userid']."',   now() ,'".$_POST['projectId']."' ) ";

		$sql = str_replace("''","null",$sql);
		$sql = str_replace("'null'","null",$sql);
		$result = execSql($db,$sql,$debug) ;


		$qsql = "SELECT currval('question_questionid_seq')";
		$qresult = execSql($db, $qsql, $debug);
		list ($qid) = pg_fetch_row($qresult,0);
		if ($_POST['answer']) {


			$postsql = "INSERT INTO answer (questionid, answerid, answer, answer_group, entered_by, entered_timestamp) values (";
			$postsql.= "'".$qid."','".$_POST['answerId']."','".$_POST['answer']."','".$_POST['answer_group']."','".$_SESSION['userid']."',now() ) ";
			$postsql = str_replace("''","null",$postsql);
			$postsql = str_replace("'null'","null",$postsql);
			$postresult = execSql($db,$postsql,$debug) ;
		}
	} else {
		$qid = $_POST['questionId'] ;
		$sql = "UPDATE question set ";
		$sql.= "question   = '".$_POST['question']."', ";
		$sql.= "usecaseid   = upper('".$_POST['usecaseId']."'), ";
		$sql.= "subject   = '".$_POST['subject']."', ";
		$sql.= "entered_by   = '".$_SESSION['userid']."', ";
		$sql.= "projectid   = '".$_POST['projectId']."', ";
		$sql.= "entered_timestamp   = now()  ";
		$sql.= "WHERE questionid   = '".$_POST['questionId']."'  ";


		$presql = "SELECT count(*) from ANSWER where questionid   = '".$_POST['questionId']."'  and answerid = '".$_POST['answerId']."'";
		$preresult = execSql ($db, $presql, $debug);
		list($anscount)= pg_fetch_row($preresult, 0);
		if ($_POST['answerId']) {
		if ($anscount > 0) {
			$postsql = "UPDATE answer SET ";
			$postsql.= " answer = '".$_POST['answer']."', "    ;
			$postsql.= " answer_group = '".$_POST['answer_group']."', "    ;
			$postsql.= "entered_by   = '".$_SESSION['userid']."', ";
			$postsql.= "entered_timestamp   = now()  ";
			$postsql.= "WHERE questionid   = '".$_POST['questionId']."' and  ";
			$postsql.= " answerid   = '".$_POST['answerId']."'  ";
		} else {
			$postsql = "INSERT INTO answer (questionid, answerid, answer, answer_group, entered_by, entered_timestamp) values (";
			$postsql.= "'".$_POST['questionId']."','".$_POST['answerId']."','".$_POST['answer']."','".$_POST['answer_group']."','".$_SESSION['userid']."',now() ) ";
		}
			$postsql = str_replace("''","null",$postsql);
			$postsql = str_replace("'null'","null",$postsql);
			$postresult = execSql($db,$postsql,$debug) ;
		}
		$sql = str_replace("''","null",$sql);
		$sql = str_replace("'null'","null",$sql);
		$result = execSql($db,$sql,$debug) ;
	}



}

   header("location: q_form.php?qId=".$qid);






?>

