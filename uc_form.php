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
function showActionType() {
	var e = document.getElementById("actionType");

	var actionTypeSelect = e.options[e.selectedIndex].value;
				
	switch (actionTypeSelect) {
	case 'actor':
              	document.getElementById("actionTypeStepHeader").style.display = 'none'; 
              	document.getElementById("actionTypeStep").style.display = 'none'; 
                document.getElementById("actionTypeValueHeader").style.display = 'none'; 
                document.getElementById("actionTypeValue").style.display = 'none'; 
               	document.getElementById("actionTypeLink").style.display = 'none'; 
               	document.getElementById("actionTypeActorHeader").style.display = ''; 
               	document.getElementById("actionTypeActor").style.display = ''; 
               	document.getElementById("actionTypeUseCaseHeader").style.display = 'none'; 
               	document.getElementById("actionTypeUseCase").style.display = 'none'; 
	break;
	case 'link':
              	document.getElementById("actionTypeStepHeader").style.display = 'none'; 
              	document.getElementById("actionTypeStep").style.display = 'none'; 
                document.getElementById("actionTypeValueHeader").style.display = 'none'; 
                document.getElementById("actionTypeValue").style.display = 'none'; 
               	document.getElementById("actionTypeActorHeader").style.display = 'none'; 
               	document.getElementById("actionTypeActor").style.display = 'none'; 
               	document.getElementById("actionTypeLink").style.display = ''; 
               	document.getElementById("actionTypeUseCaseHeader").style.display = 'none'; 
               	document.getElementById("actionTypeUseCase").style.display = 'none'; 
	break;
	case 'superordinate':
              	document.getElementById("actionTypeStepHeader").style.display = 'none'; 
              	document.getElementById("actionTypeStep").style.display = 'none'; 
                document.getElementById("actionTypeValueHeader").style.display = 'none'; 
                document.getElementById("actionTypeValue").style.display = 'none'; 
               	document.getElementById("actionTypeActorHeader").style.display = 'none'; 
               	document.getElementById("actionTypeActor").style.display = 'none'; 
               	document.getElementById("actionTypeLink").style.display = 'none'; 
               	document.getElementById("actionTypeUseCaseHeader").style.display = ''; 
               	document.getElementById("actionTypeUseCase").style.display = ''; 
	break;
	case 'subordinate':
              	document.getElementById("actionTypeStepHeader").style.display = 'none'; 
              	document.getElementById("actionTypeStep").style.display = 'none'; 
                document.getElementById("actionTypeValueHeader").style.display = 'none'; 
                document.getElementById("actionTypeValue").style.display = 'none'; 
               	document.getElementById("actionTypeActorHeader").style.display = 'none'; 
               	document.getElementById("actionTypeActor").style.display = 'none'; 
               	document.getElementById("actionTypeLink").style.display = 'none'; 
               	document.getElementById("actionTypeUseCaseHeader").style.display = ''; 
               	document.getElementById("actionTypeUseCase").style.display = ''; 
	break;
	default:
               	document.getElementById("actionTypeStepHeader").style.display = ''; 
               	document.getElementById("actionTypeStep").style.display = ''; 
               	document.getElementById("actionTypeValueHeader").style.display = ''; 
               	document.getElementById("actionTypeValue").style.display = ''; 
               	document.getElementById("actionTypeLink").style.display = 'none'; 
              	document.getElementById("actionTypeActorHeader").style.display = 'none'; 
              	document.getElementById("actionTypeActor").style.display = 'none'; 
               	document.getElementById("actionTypeUseCaseHeader").style.display = 'none'; 
               	document.getElementById("actionTypeUseCase").style.display = 'none'; 
	}

}
function check_usecaseId() {
    var return_id=false
    var inp02=document.mainform.usecaseId.value
    var inp03=document.mainform.origusecaseId.value
    if (inp02=="") {
     alert("Field: Use Case Id is Mandatory -- please enter")
    } else {
      if (inp02==inp03) {
             return_id=true
      } else {
		if (inp03!="") {
	              if (confirm("New Use Case ID from '"+inp03+"' to '"+inp02+"'?")) {
        	              return_id=true
	              }
		} else {
        	              return_id=true
		}
      }
    }
    return return_id
}
function check_usecaseVersion() {
    var return_version=false
    var inp02=document.mainform.usecaseVersion.value
    if (inp02=="") {
     alert("Field: Use Case Version is Mandatory -- please enter")
    } else {
	     return_version=true
    }
    return return_version
}
function check_usecaseName() {
    var return_Name=false
    var inp02=document.mainform.usecaseName.value
    var inp03=document.mainform.origusecaseName.value
    if (inp02=="") {
     alert("Field: Use Case Name is Mandatory -- please enter")
    } else {
      if (inp02==inp03) {
             return_Name=true
      } else {
		if (inp03 != "") {
	              if (confirm("Update Use Case Name from '"+inp03+"' to '"+inp02+"'?")) {
        	              return_Name=true
	              }
		} else {
			return_Name=true
		}
      }
    }
    return return_Name
}
function check_projectId() {
    var return_projectid=false
    var inp02=document.mainform.projectId.value
    if (inp02=="") {
     alert("Field: Project Id is Mandatory -- please enter")
    } else {
             return_projectid=true
    }
    return return_projectid
}
function check_goalInContext() {
    var return_goal=false
    var inp02=document.mainform.goalInContext.value
    if (inp02=="") {
     alert("Field: Goal in Context is Mandatory -- please enter")
    } else {
     return_goal=true
    }
    return return_goal
}
function check_successCondition() {
    var return_condition=false
    var inp02=document.mainform.successCondition.value
    if (inp02=="") {
     alert("Field: Success Condition is Mandatory -- please enter")
    } else {
     return_condition=true
    }
    return return_condition
}
function chkForm1() {
   varF1C=check_usecaseName();
   if (varF1C==false) {
       document.mainform.usecaseName.focus() ;
       return false ;
   }
   varF1D=check_usecaseVersion();
   if (varF1D==false) {
       document.mainform.usecaseVersion.focus()
       return false
   }
   varF1G=check_projectId();
   if (varF1G==false) {
       document.mainform.projectId.focus()
       return false
   }
   varF1E=check_goalInContext();
   if (varF1E==false) {
       document.mainform.goalInContext.focus()
       return false
   }
   varF1F=check_successCondition();
   if (varF1F==false) {
       document.mainform.successCondition.focus()
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
   <h1>Use Case Template <?php echo $rep_name ?></h1>

 <form name="mainform" method="post" ACTION="uc_add.php" > 

	<table border=4 cellspacing=0 cellpadding=2 bordercolor=#eeeeee width=850> 


<?

if (!$_GET['ucId']) {
	$usecaseplaceholder = '<new>' ;
	$usecaseVersion = 0;
	$readoption = '';
} else {
	$usecaseId = $_GET['ucId'] ;

	$readoption = 'readonly';
	$showMulti = 1;

	$presql = "select * from use_case where usecaseid = '".$usecaseId."'  ";
	$preresult = execSql($db, $presql, $debug) ;
        	list ($ucId, $usecaseVersion, $usecaseName, $goalInContext, $narrative, $scope, $successCondition, $failCondition, $trigger, $priority, $performance, $frequency, $owner, $statusdate, $createdby, $uc_tier, $projectid, $ucNum) = pg_fetch_row($preresult, 0);

}
?>


<tr>
<td> <b>ID:</b></td><td>
    <input type="hidden" name="origusecaseId" value="<?php echo $usecaseId ?>"> 
    <input type="text" id="usecaseId" name="usecaseId" readonly size="10" maxlength="10" placeholder="<?php echo $usecaseplaceholder ?>" value="<?php echo $usecaseId ?>"></td>
<td> <b>Version:</b></td><td>
    <input type="text" id="usecaseVersion" name="usecaseVersion" size="10" maxlength="10" value="<?php echo $usecaseVersion ?>"></td>
<td> <b>Name:</b></td><td>
    <input type="hidden" name="origusecaseName" value="<?php echo $usecaseName ?>"> 
    <input type="text"  name="usecaseName" value="<?php echo $usecaseName ?>"  size="25" maxlength="70"></td>
</tr>
<tr>
<td> Tier:</td><td>
<?
  		echo '<select name="ucTier">';
 
  			$relationship_all = pg_exec($db,"SELECT item_cd, item_description from app_lookup where lookup_table = 'generic' and lookup_field = 'tier' order by sort_order "); 
			$rownum = 0;
				while ($relationship_row = pg_fetch_array($relationship_all, $rownum)) {
  					$item_description = $relationship_row["item_description"];
  					$item_cd = $relationship_row["item_cd"];
					$rownum = $rownum + 1;
					if ($item_cd == $uc_tier) {
  					echo "<option selected value='$item_cd'>".$item_cd." - ".$item_description."</option>";
					} else {
  					echo "<option value='$item_cd'>".$item_cd." - ".$item_description."</option>";
					}
  				}
  		echo "</select></td>";
?>
<td> Project:</td><td>
<?
  		echo '<select name="projectId">';
 
                        $relationship_all = pg_exec($db,"SELECT projectid, project_name from project where projectid in (select projectid from project_user where employee_id = '".$_SESSION['userid']."') order by 2 ");

			$rownum = 0;
				while ($relationship_row = pg_fetch_array($relationship_all, $rownum)) {
  					$item_description = $relationship_row["project_name"];
  					$item_cd = $relationship_row["projectid"];
					$rownum = $rownum + 1;
					if ($item_cd == $projectid) {
  					echo "<option selected value='$item_cd'>".$item_cd." - ".$item_description."</option>";
					} else {
  					echo "<option value='$item_cd'>".$item_cd." - ".$item_description."</option>";
					}
  				}
  		echo "</select></td>";
?>
</tr>
<tr>
<td> <b>Goal in Context:</b></td><td colspan=7><TEXTAREA name="goalInContext" rows="3" cols="130"><?php echo $goalInContext ?></textarea>
</td>
</tr>
<tr>
<td> Narrative:</td><td colspan=7><TEXTAREA name="narrative" rows="3" cols="130"><?php echo $narrative ?></textarea>
</td>
</tr>
<tr>
<td> Scope:</td><td colspan=7><TEXTAREA name="scope" rows="3" cols="130"><?php echo $scope ?></textarea>
</td>
</tr>
<tr>
<?
// <td> Preconditions:</td><td colspan=7><table border=2>
	$sql = "select action_step, action_value, action_inc from use_case_action where usecaseid = '".$usecaseId."' and action_type = 'precondition' order by action_step ";
	$relationship_all = execSql ($db, $sql, $debug);
	$pre_rows = pg_num_rows($relationship_all) ;
	$bordervalue = $pre_rows > 0 ? 2 : 0;
	echo "<td> Preconditions:</td><td colspan=7><table border=".$bordervalue.">";
			$rownum = 0;
				while ($relationship_row = pg_fetch_array($relationship_all, $rownum)) {
  					$item_step = $relationship_row["action_step"];
  					$item_value = $relationship_row["action_value"];
  					$item_inc = $relationship_row["action_inc"];
				echo '<tr><td><a onclick="window.open(\'uc_action_form.php?ucId='.$usecaseId.'&at=precondition&ac='.$item_inc.'\',\'name\',\'width=800,height=600\')">'.$item_step.'</a></td><td colspan=50 >'.$item_value.'</td></tr>';
					$rownum = $rownum + 1;
  				}
?>
</table>
</td>
</tr>
<tr>
<td> <b>Success Condition:</b></td><td colspan=7><TEXTAREA name="successCondition" rows="3" cols="130"><?php echo $successCondition ?></textarea>
</td>
</tr>
<tr>
<td> Failure Condition:</td><td colspan=7><TEXTAREA name="failCondition" rows="3" cols="130"><?php echo $failCondition ?></textarea>
</td>
</tr>
<tr>
<?
	$sql = "select actor, action_inc from use_case_action where usecaseid = '".$usecaseId."' and action_type = 'actor' order by actor ";
	$relationship_all = execSql ($db, $sql, $debug);
	$act_rows = pg_num_rows($relationship_all) ;
	$bordervalue = $act_rows > 0 ? 2 : 0;
	echo "<td> Actors:</td><td colspan=7><table border=".$bordervalue.">";
			$rownum = 0;
				while ($relationship_row = pg_fetch_array($relationship_all, $rownum)) {
  					$item_value = $relationship_row["actor"];
  					$item_inc = $relationship_row["action_inc"];
				echo '<tr><td><a onclick="window.open(\'uc_action_form.php?ucId='.$usecaseId.'&at=actor&ac='.$item_inc.'\',\'name\',\'width=800,height=600\')">'.$item_value.'</a></td></tr>';
//					echo "<tr><td>".$item_value."</td></tr>";
					$rownum = $rownum + 1;
  				}
?>
</table>
</td>
</tr>
<tr>
<td> Trigger:</td><td colspan=7><TEXTAREA name="trigger" rows="3" cols="130"><?php echo $trigger ?></textarea>
</td>
</tr>
<tr>
<?
	$sql = "select action_step, action_value, action_inc from use_case_action where usecaseid = '".$usecaseId."' and action_type = 'scenario' order by action_step "; 
	$relationship_all = execSql ($db, $sql, $debug);
	$sce_rows = pg_num_rows($relationship_all) ;
	$bordervalue = $sce_rows > 0 ? 2 : 0;
//	echo "<td> Scenario:</td><td colspan=7><table border=".$bordervalue.">";
        echo '<td><a onclick="window.open(\'renumber_form.php?utype=uc&at=scenario&ac=scenario&id='.$usecaseId.'\',\'name\',\'width=1200,height=600\')">Scenario</a></td>';
	echo "<td colspan=7><table border=".$bordervalue.">";
			$rownum = 0;
				while ($relationship_row = pg_fetch_array($relationship_all, $rownum)) {
  					$item_step = $relationship_row["action_step"];
  					$item_value = $relationship_row["action_value"];
  					$item_inc = $relationship_row["action_inc"];
				echo '<tr><td><a onclick="window.open(\'uc_action_form.php?ucId='.$usecaseId.'&at=scenario&ac='.$item_inc.'\',\'name\',\'width=800,height=600\')">'.$item_step.'</a></td><td colspan=50 >'.$item_value.'</td></tr>';
					$rownum = $rownum + 1;
  				}
?>

</table>
</td>
</tr>
<tr>
<?
	$sql = "select action_step, action_value, action_inc from use_case_action where usecaseid = '".$usecaseId."' and action_type = 'extention' order by action_step "; 
	$relationship_all = execSql ($db, $sql, $debug);
	$ext_rows = pg_num_rows($relationship_all) ;
	$bordervalue = $ext_rows > 0 ? 2 : 0;
	echo "<td> Extentions:</td><td colspan=7><table border=".$bordervalue.">";
			$rownum = 0;
				while ($relationship_row = pg_fetch_array($relationship_all, $rownum)) {
  					$item_step = $relationship_row["action_step"];
  					$item_value = $relationship_row["action_value"];
  					$item_inc = $relationship_row["action_inc"];
				echo '<tr><td><a onclick="window.open(\'uc_action_form.php?ucId='.$usecaseId.'&at=extention&ac='.$item_inc.'\',\'name\',\'width=800,height=600\')">'.$item_step.'</a></td><td colspan=50 >'.$item_value.'</td></tr>';
					$rownum = $rownum + 1;
  				}
?>

</table>
</td>
</tr>
<tr>
<?
	$sql = "select action_step, action_value, action_inc from use_case_action where usecaseid = '".$usecaseId."' and action_type = 'variation' order by action_step "; 
	$relationship_all = execSql ($db, $sql, $debug);
	$var_rows = pg_num_rows($relationship_all) ;
	$bordervalue = $var_rows > 0 ? 2 : 0;
	echo "<td> Variations:</td><td colspan=7><table border=".$bordervalue.">";
			$rownum = 0;
				while ($relationship_row = pg_fetch_array($relationship_all, $rownum)) {
  					$item_step = $relationship_row["action_step"];
  					$item_value = $relationship_row["action_value"];
  					$item_inc = $relationship_row["action_inc"];
				echo '<tr><td><a onclick="window.open(\'uc_action_form.php?ucId='.$usecaseId.'&at=variation&ac='.$item_inc.'\',\'name\',\'width=800,height=600\')">'.$item_step.'</a></td><td colspan=50 >'.$item_value.'</td></tr>';
					$rownum = $rownum + 1;
  				}
?>

</table>
</td>
</tr>
<tr>
<?
	$sql = "select action_step, action_value, action_inc from use_case_action where usecaseid = '".$usecaseId."' and action_type = 'exception' order by action_step "; 
	$relationship_all = execSql ($db, $sql, $debug);
	$exc_rows = pg_num_rows($relationship_all) ;
	$bordervalue = $exc_rows > 0 ? 2 : 0;
	echo "<td> Exceptions:</td><td colspan=7><table border=".$bordervalue.">";
			$rownum = 0;
				while ($relationship_row = pg_fetch_array($relationship_all, $rownum)) {
  					$item_step = $relationship_row["action_step"];
  					$item_value = $relationship_row["action_value"];
  					$item_inc = $relationship_row["action_inc"];
				echo '<tr><td><a onclick="window.open(\'uc_action_form.php?ucId='.$usecaseId.'&at=exception&ac='.$item_inc.'\',\'name\',\'width=800,height=600\')">'.$item_step.'</a></td><td colspan=50 >'.$item_value.'</td></tr>';
					$rownum = $rownum + 1;
  				}
?>

</table>
</td>
</tr>

<tr>
<td colspan=8>&nbsp;</td>
</tr>
<tr>
<td> Priority:</td><td>
<?
  		echo '<select name="priority">';
 		echo '<option value="'.$no_prelationship.'" >'.$no_prelationship.'</option>';
 
  			$relationship_all = pg_exec($db,"SELECT item_cd, item_description from app_lookup where lookup_table = 'use_case' and lookup_field = 'priority' order by sort_order "); 
			$rownum = 0;
				while ($relationship_row = pg_fetch_array($relationship_all, $rownum)) {
  					$item_description = $relationship_row["item_description"];
  					$item_cd = $relationship_row["item_cd"];
					$rownum = $rownum + 1;
					if ($item_cd == $priority) {
  					echo "<option selected value='$item_cd'>".$item_cd." - ".$item_description."</option>";
					} else {
  					echo "<option value='$item_cd'>".$item_cd." - ".$item_description."</option>";
					}
  				}
  		echo "</select></td>";
?>
<td> Performance:</td><td>
    <input type="text" id="performance" name="performance" value="<?php echo $performance ?>"  size="15" maxlength="40" ></td>
<td> Frequency:</td><td>
    <input type="text"  name="frequency" value="<?php echo $frequency ?>"  size="25" maxlength="40"></td>
</tr>
<tr>
<?
	$sql = "select action_step, action_value, action_inc from use_case_action where usecaseid = '".$usecaseId."' and action_type = 'open' order by action_step "; 
	$relationship_all = execSql ($db, $sql, $debug);
	$opn_rows = pg_num_rows($relationship_all) ;
	$bordervalue = $opn_rows > 0 ? 2 : 0;
	echo "<td> Open Issues:</td><td colspan=7><table border=".$bordervalue.">";
			$rownum = 0;
				while ($relationship_row = pg_fetch_array($relationship_all, $rownum)) {
  					$item_step = $relationship_row["action_step"];
  					$item_value = $relationship_row["action_value"];
  					$item_inc = $relationship_row["action_inc"];
				echo '<tr><td><a onclick="window.open(\'uc_action_form.php?ucId='.$usecaseId.'&at=open&ac='.$item_inc.'\',\'name\',\'width=800,height=600\')">'.$item_step.'</a></td><td colspan=50 >'.$item_value.'</td></tr>';
					$rownum = $rownum + 1;
  				}
?>
</table>
</td>
</tr>
<tr>
<?
        $sql = "select uc.action_value, uc.action_step, u.usecasename, uc.action_inc, uc.usecaseid from use_case_action uc, use_case u where uc.usecaseid = u.usecaseid and uc.action_value = '".$usecaseId."' and uc.action_type = 'subordinate' order by uc.action_value ";

	$relationship_all = execSql ($db, $sql, $debug);
	$sup_rows = pg_num_rows($relationship_all) ;
	$bordervalue = $sup_rows > 0 ? 2 : 0;
	echo "<td> Superordinates:</td><td colspan=7><table border=".$bordervalue.">";
			$rownum = 0;
				while ($relationship_row = pg_fetch_array($relationship_all, $rownum)) {
  					$item_step = $relationship_row["action_step"];
  					$item_value = $relationship_row["action_value"];
  					$item_ucid = $relationship_row["usecaseid"];
  					$item_name = $relationship_row["usecasename"];
  					$item_inc = $relationship_row["action_inc"];
				echo '<tr><td><a onclick="window.open(\'uc_action_form.php?ucId='.$item_ucid.'&at=subordinate&ac='.$item_inc.'\',\'name\',\'width=800,height=600\')">'.$item_step.'</a></td>';
				echo '<td colspan=50 ><a onclick="window.open(\'uc_form.php?ucId='.$item_ucid.'\',\'name\',\'width=1200,height=800\')">'.$item_ucid.'</a></td>';
				echo '<td>'.$item_name.'</td></tr>';
					$rownum = $rownum + 1;
  				}
?>
</table>
</td>
</tr>
<tr>
<?
	$sql = "select uc.action_step, uc.action_value, uc.action_inc, u.usecasename from use_case_action uc, use_case u where uc.action_value = u.usecaseid and uc.usecaseid = '".$usecaseId."' and uc.action_type = 'subordinate' order by uc.action_step "; 
	$relationship_all = execSql ($db, $sql, $debug);
	$sub_rows = pg_num_rows($relationship_all) ;
	$bordervalue = $sub_rows > 0 ? 2 : 0;
	echo "<td> Subordinates:</td><td colspan=7><table border=".$bordervalue.">";
			$rownum = 0;
				while ($relationship_row = pg_fetch_array($relationship_all, $rownum)) {
  					$item_step = $relationship_row["action_step"];
  					$item_value = $relationship_row["action_value"];
  					$item_name = $relationship_row["usecasename"];
  					$item_inc = $relationship_row["action_inc"];
				echo '<tr><td><a onclick="window.open(\'uc_action_form.php?ucId='.$usecaseId.'&at=subordinate&ac='.$item_inc.'\',\'name\',\'width=800,height=600\')">'.$item_step.'</a></td>';
				echo '<td colspan=50 ><a onclick="window.open(\'uc_form.php?ucId='.$item_value.'\',\'name\',\'width=1200,height=800\')">'.$item_value.'</a></td>';
				echo '<td>'.$item_name.'</tr>';
					$rownum = $rownum + 1;
  				}
?>
</table>
</td>
</tr>



</td>
</tr>
<tr>
<td colspan=8>&nbsp;</td>
</tr>



<?php

 echo "<tr><td colspan=6>&nbsp;</td></tr>";
?>

<br>

<?

$sql="SELECT * from app_lookup where lookup_table = 'report_menux' order by sort_order";

$result = pg_exec($db,$sql);
if(pg_ErrorMessage($db))
        {
        if ($debug) {
                DisplayErrMsg(sprintf("Error in executing %s statement", $sql)) ;
        }
        DisplayErrMsg(sprintf("Error: %s", pg_ErrorMessage($db))) ;
        };


echo "<br>";
$rownum = 0;

while ($row = pg_fetch_array($result,$rownum))
{
$test=$row[pg_fieldname($result,0)];

echo "<tr><td align=center colspan=2><b><a href='".$row[pg_fieldname($result,4)]."'>".$row[pg_fieldname($result,2)]."</a></b></td><td colspan=2>".$row[pg_fieldname($result,3)]."</td></tr>";

$rownum = $rownum + 1;
}

$sql="SELECT * from user_query where user_id='".$userid."' order by query_name";

$result = pg_exec($db,$sql);
if(pg_ErrorMessage($db))
        {
        if ($debug) {
                DisplayErrMsg(sprintf("Error in executing %s statement", $sql)) ;
        }
        DisplayErrMsg(sprintf("Error: %s", pg_ErrorMessage($db))) ;
        };


echo "<br>";
$rownum = 0;

while ($row = pg_fetch_array($result,$rownum))
{
$test=$row[pg_fieldname($result,0)];

echo "<tr><td align=center colspan=2><b><a href='run_user_query.php?query_name=".$row[pg_fieldname($result,1)]."'>".$row[pg_fieldname($result,1)]."</a></b></td><td colspan=2>".$row[pg_fieldname($result,2)]."</td></tr>";

$rownum = $rownum + 1;
}


		echo '<tr><td>Actions:</td><td id="actionTypeStepHeader" style="display:none">Step</td><td colspan=3 id="actionTypeValueHeader" style="display:none">Value</td><td id="actionTypeActorHeader" style="display:none">Actor';
		echo '<td id="actionTypeUseCaseHeader" style="display:none">Use Case';
		echo "<input class=asLabel type=text id=currentrelperson name=currentperson readonly></td></tr>";

                echo '<input type="hidden" name="crosspersonid['.$prownum.']" value="'.$ppersonId.'">';
  		echo '<td valign=top>';
		echo '<select id="actionType" name="actionType" onchange="showActionType();">';
 		echo '<option selected value=""></option>';
 
  			$relationship_all = pg_exec($db,"SELECT item_cd, item_description from app_lookup where lookup_table = 'use_case_action' and lookup_field = 'action_type' order by sort_order "); 
			$rownum = 0;
				while ($relationship_row = pg_fetch_array($relationship_all, $rownum)) {
  					$item_description = $relationship_row["item_description"];
  					$item_cd = $relationship_row["item_cd"];
					$rownum = $rownum + 1;
  					echo "<option value='$item_cd'>$item_description</option>";
  				}
  		echo "</select></td>";
		
		echo '<td valign=top id="actionTypeStep" style="display:none"><input type=text id=stepNo name=stepNo></td>';
		echo '<td colspan=3 id="actionTypeValue" style="display:none"><TEXTAREA name="nextStep" rows="3" cols="80"></textarea></td>';


		echo '<td valign=top id="actionTypeActor" style="display:none">';
  		echo '<select name="actor">';
 		echo '<option value="'.$no_prelationship.'" >'.$no_prelationship.'</option>';
 
  			$relationship_all = pg_exec($db,"SELECT actor, actor||'  ('||actor_type||')' as actortype from actor_type order by sort_order "); 
			$rownum = 0;
				while ($relationship_row = pg_fetch_array($relationship_all, $rownum)) {
  					$item_description = $relationship_row["actortype"];
  					$item_cd = $relationship_row["actor"];
					$rownum = $rownum + 1;
  					echo "<option value='$item_cd'>$item_description</option>";
  				}
  		echo "</select>";
		echo "</td>";
		echo '<td valign=top id="actionTypeLink" style="display:none">';
  		echo '<select name="linkvalue">';
 		echo '<option value="'.$no_prelationship.'" >'.$no_prelationship.'</option>';
 
	
  			$relationship_all = pg_exec($db,"SELECT a.usecaseid||'-'||a.action_inc as ucai, u.usecasename||' -- '||a.action_value||'  (step:'||a.action_step||')' as actortype from use_case_action a, use_case u  where a.usecaseid = u.usecaseid and a.action_type = 'scenario' order by 1 "); 
			$rownum = 0;
				while ($relationship_row = pg_fetch_array($relationship_all, $rownum)) {
  					$item_description = $relationship_row["actortype"];
  					$item_cd = $relationship_row["ucai"];
					$rownum = $rownum + 1;
  					echo "<option value='$item_cd'>$item_description</option>";
  				}
  		echo "</select>";
		echo "</td>";

		echo '<td id="actionTypeUseCase" style="display:none">';
  		echo '<select name="actionUseCase">';
 		echo '<option value="'.$no_prelationship.'" >'.$no_prelationship.'</option>';
 
	
  			$relationship_all = pg_exec($db,"SELECT u.usecaseid as ucai, u.usecasename||' (Tier: '||coalesce(u.uc_tier,1)||')' as uc_description from  use_case u   order by 2 "); 
			$rownum = 0;
				while ($relationship_row = pg_fetch_array($relationship_all, $rownum)) {
  					$item_description = $relationship_row["uc_description"];
  					$item_cd = $relationship_row["ucai"];
					$rownum = $rownum + 1;
  					echo "<option value='$item_cd'>$item_description</option>";
  				}
  		echo "</select>";
		echo "</td>";

		echo "</tr>";

 echo "<tr><td colspan=6>&nbsp;</td></tr>";
 echo "<tr>";

	$sql = "select doc_type, doc_name, doc_dir, document_description from use_case_document where usecaseid = '".$usecaseId."' order by doc_name "; 
	$doc_all = execSql ($db, $sql, $debug);
	$doc_rows = pg_num_rows($doc_all) ;
	$bordervalue = $doc_rows > 0 ? 1 : 0;
	if ($doc_rows > 0) {
	echo "<td> Documents:</td><td colspan=7><table border=".$bordervalue.">";
				echo '<tr><td>Document Type</td><td>Document Name</td><td>Document Description</td>';

			$rownum = 0;
				while ($relationship_row = pg_fetch_array($doc_all, $rownum)) {
  					$item_type = $relationship_row["doc_type"];
  					$item_name = $relationship_row["doc_name"];
  					$item_dir = $relationship_row["doc_dir"];
  					$item_desc = $relationship_row["document_description"];
				echo "<tr><td>".$item_type."</td><td><a href='".$item_dir.$item_name."' target='_blank'>".$item_name."</a></td>";
				if ($item_desc) {
					echo '<td>'.$item_desc.'</td>';
				} else {
					echo '<td>&nbsp;</td>';
				}
					echo '</tr>';
					$rownum = $rownum + 1;
  				}
 echo "</table></td></tr>";
}
 echo "<tr><td colspan=6>&nbsp;</td></tr>";


		
?>

    <tr>
    <td colspan=8><input class="gray" type="Submit" name="formsubmit"  onclick="return ValidateForm()">
    &nbsp;&nbsp;<input class="gray" type="Submit" name="formmenu" value="Menu">&nbsp;&nbsp;
<?
 echo "<input class=gray type=Button name=FORMNUM value=\"Upload Docs\" onClick=\"window.open('doc_file_upload.php?ucid=".$usecaseId."','newWin','scrollbars=yes,status=no,toolbar=no,directories=no,resizable=no,screenX=100,screenY=500,top=100,left=500,width=750,height=400')\"> ";
?>
    &nbsp;&nbsp;<input class="gray" type="Submit" name="formcopy" value="copy form" onclick="return ValidateForm()">
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
