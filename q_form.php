<?php
session_start();
include("inc/dbconnect.php");


$show_menu="ON";

 include("inc/index_header_inc.php"); 


?>
<HTML>
<head>
<style type="text/css">
   input.asLabel
   {
      border: none;
      background: transparent;
   }
</style>
<script language = "Javascript">

function hideshow(which){
	alert ('which is '+which.style.display);
	if (!document.getElementById)
return
	if (which.style.display=="block")
		which.style.display="none"
	else
	which.style.display="block"
}
function check_question() {
    var return_q=false
    var inp02=document.mainform.question.value
    if (inp02=="") {
     alert("Field: Question is Mandatory -- please enter")
    } else {
     return_q=true
    }
    return return_q
}
function check_projectid() {
    var return_pid=false
    var inp02=document.mainform.projectId.value
    if (inp02=="") {
     alert("Field: Project Id is Mandatory -- please enter")
    } else {
     return_pid=true
    }
    return return_pid
}
function chkForm1() {
   varF1E=check_question();
   if (varF1E==false) {
       document.mainform.question.focus()
       return false
   }
   varF1E=check_projectid();
   if (varF1E==false) {
       document.mainform.projectId.focus()
       return false
   }
return true;
}
function ValidateForm(){
        if (chkForm1()==false){
                return false
        } else {
                return true
        }
}

</script>
</head>
<tr><td>
  <blockquote>
   <h1>Question <?php echo $rep_name ?></h1>

 <form name="mainform" method="post" ACTION="q_add.php" > 

	<table border=4 cellspacing=0 cellpadding=2 bordercolor=#eeeeee width=850> 


<?

if (!$_GET['qId']) {
} else {
	$questionId = $_GET['qId'] ;

	$readoption = 'readonly';
	$showMulti = 1;

	$presql = "select question, subject, usecaseid,projectid from question where questionid = '".$questionId."'  ";
	$preresult = execSql($db, $presql, $debug) ;
        	list ($question, $subject, $usecaseid,$projectid) = pg_fetch_row($preresult, 0);
	$anssql = "select answerid, answer_group, answer FROM answer where questionid = '".$questionId."' limit 1";
	$ansresult = execSql($db, $anssql, $debug);
		list ($answerId, $answer_group, $answer) = pg_fetch_row($ansresult,0);

}
?>


<tr>
<td> ID:</td><td>
    <input type="text" id="questionId" name="questionId" size="10" maxlength="10" readonly value="<?php echo $questionId ?>"></td>
<td> Subject:</td><td>
<?
  		echo '<select name="subject">';
 		echo '<option value="'.$no_prelationship.'" >'.$no_prelationship.'</option>';
 
  			$relationship_all = pg_exec($db,"SELECT subject, subject_desc from subject order by sort_order "); 
			$rownum = 0;
				while ($relationship_row = pg_fetch_array($relationship_all, $rownum)) {
  					$item_description = $relationship_row["subject_desc"];
  					$item_cd = $relationship_row["subject"];
					$rownum = $rownum + 1;
					if ($item_cd == $subject) {
  					echo "<option selected value='$item_cd'>".$item_description."</option>";
					} else {
  					echo "<option value='$item_cd'>".$item_description."</option>";
					}
  				}
  		echo "</select></td>";
?>

<td> Project Id:</td><td colspan=4>
<?
  		echo '<select name="projectId">';
 		echo '<option value="'.$no_prelationship.'" >'.$no_prelationship.'</option>';
 
  			$relationship_all = pg_exec($db,"SELECT pu.projectid, p.project_name from project_user pu, project p WHERE pu.projectid = p.projectid and pu.employee_id = '".$_SESSION['userid']."' order by p.project_name "); 
			$rownum = 0;
				while ($relationship_row = pg_fetch_array($relationship_all, $rownum)) {
  					$item_description = $relationship_row["project_name"];
  					$item_cd = $relationship_row["projectid"];
					$rownum = $rownum + 1;
					if ($item_cd == $projectid) {
  					echo "<option selected value='$item_cd'>".$item_description."</option>";
					} else {
  					echo "<option value='$item_cd'>".$item_description."</option>";
					}
  				}
  		echo "</select></td>";
?>

</tr>
<tr>
<td> Use Case:</td><td colspan=4>
<?
  		echo '<select name="usecaseId">';
 		echo '<option value="'.$no_prelationship.'" >'.$no_prelationship.'</option>';
 
  			$relationship_all = pg_exec($db,"SELECT usecaseid, usecasename from use_case WHERE projectid in (select projectid FROM project_user WHERE employee_id = '".$_SESSION['userid']."') order by usecasename "); 
			$rownum = 0;
				while ($relationship_row = pg_fetch_array($relationship_all, $rownum)) {
  					$item_description = $relationship_row["usecasename"];
  					$item_cd = $relationship_row["usecaseid"];
					$rownum = $rownum + 1;
					if ($item_cd == $usecaseid) {
  					echo "<option selected value='$item_cd'>".$item_description." (".$item_cd.")</option>";
					} else {
  					echo "<option value='$item_cd'>".$item_description." (".$item_cd.")</option>";
					}
  				}
  		echo "</select></td>";
?>
</tr>
<tr>
<td> <b>Question:</b></td><td colspan=7><TEXTAREA name="question" rows="5" cols="150"><?php echo $question ?></textarea>
</td>
</tr>


</td>
</tr>
<tr>
<td colspan=8>&nbsp;</td>
</tr>



<?php

 echo "<tr><td colspan=6>&nbsp;</td></tr>";
 echo "<tr><td colspan=6>&nbsp;</td></tr>";
 echo "<tr><td colspan=6>Answer:</td></tr>";

if (!$answerId) {
	$answerId = 1;
}

echo "<tr>";
echo "<td> ID:</td><td>";
echo     '<input type="text" id="answerId" name="answerId" readonly size="10" maxlength="10" value="'.$answerId.'"></td>';
echo "<td> Answer Group:</td><td>";

  		echo '<select name="answer_group">';
 		echo '<option value="'.$no_prelationship.'" >'.$no_prelationship.'</option>';
 
  			$relationship_all = pg_exec($db,"SELECT distinct answer_group from answer order by 1 "); 
			$rownum = 0;
				while ($relationship_row = pg_fetch_array($relationship_all, $rownum)) {
  					$item_cd = $relationship_row["answer_group"];
					$rownum = $rownum + 1;
					if ($item_cd == $answer_group) {
  					echo "<option selected value='$item_cd'>".$item_cd."</option>";
					} else {
  					echo "<option value='$item_cd'>".$item_cd."</option>";
					}
  				}
  		echo "</select></td>";
?>


</tr>
<tr>
<td> <b>Answer:</b></td><td colspan=7><TEXTAREA name="answer" rows="5" cols="150"><?php echo $answer ?></textarea>
</td>
</tr>


</td>
</tr>




 <tr><td colspan=6>&nbsp;</td></tr>








<br>

    <tr>
    <td colspan=8><input class="gray" type="Submit" name="formsubmit"  value="Submit" onclick="return ValidateForm()">
    &nbsp;&nbsp;<input class="gray" type="Submit" name="formmenu" value="Menu">&nbsp;&nbsp;
<?
/*
 echo "<input class=gray type=Button name=FORMNUM value=\"Upload Docs\" onClick=\"window.open('doc_file_upload.php?ucid=".$usecaseId."','newWin','scrollbars=yes,status=no,toolbar=no,directories=no,resizable=no,screenX=100,screenY=500,top=100,left=500,width=750,height=400')\"> ";
*/
?>
	</td>
              </tr>
</table>
    </p>
  </form>
</blockquote>
<?

include "inc/footer_inc.php";
?>
</body>
</HTML>
