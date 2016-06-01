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
textarea{
# width:600px;
height:100px;
border:1px solid #000000;
background-color:#FFFFFF;
}
input::-webkit-input-placeholder, textarea::-webkit-input-placeholder { 
    color:    #666;
}
input:-moz-placeholder, textarea:-moz-placeholder { 
    color:    #666;
}
input::-moz-placeholder, textarea::-moz-placeholder { 
    color:    #666;
}
input:-ms-input-placeholder, textarea:-ms-input-placeholder { 
    color:    #666;
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
                document.getElementById("actionTypeValueHeader").style.display = 'none'; 
                document.getElementById("actionTypeValue").style.display = 'none'; 
               	document.getElementById("actionTypeLinkHeader").style.display = 'none'; 
               	document.getElementById("actionTypeLink").style.display = 'none'; 
                document.getElementById("actionTypeUserStoryHeader").style.display = 'none'; 
                document.getElementById("actionTypeUserStory").style.display = 'none'; 
               	document.getElementById("actionTypeCommentHeader").style.display = 'none'; 
               	document.getElementById("actionTypeComment").style.display = 'none'; 
               	document.getElementById("actionTypeXrefHeader").style.display = 'none'; 
               	document.getElementById("actionTypeXref").style.display = 'none'; 
	break;
	case 'link':
                document.getElementById("actionTypeValueHeader").style.display = 'none'; 
                document.getElementById("actionTypeValue").style.display = 'none'; 
               	document.getElementById("actionTypeLinkHeader").style.display = ''; 
               	document.getElementById("actionTypeLink").style.display = ''; 
                document.getElementById("actionTypeUserStoryHeader").style.display = 'none'; 
                document.getElementById("actionTypeUserStory").style.display = 'none'; 
               	document.getElementById("actionTypeCommentHeader").style.display = ''; 
               	document.getElementById("actionTypeComment").style.display = ''; 
               	document.getElementById("actionTypeXrefHeader").style.display = 'none'; 
               	document.getElementById("actionTypeXref").style.display = 'none'; 
	break;
	case 'superordinate':
                document.getElementById("actionTypeValueHeader").style.display = 'none'; 
                document.getElementById("actionTypeValue").style.display = 'none'; 
               	document.getElementById("actionTypeLinkHeader").style.display = 'none'; 
               	document.getElementById("actionTypeLink").style.display = 'none'; 
                document.getElementById("actionTypeUserStoryHeader").style.display = ''; 
                document.getElementById("actionTypeUserStory").style.display = ''; 
               	document.getElementById("actionTypeCommentHeader").style.display = 'none'; 
               	document.getElementById("actionTypeComment").style.display = 'none'; 
               	document.getElementById("actionTypeXrefHeader").style.display = 'none'; 
               	document.getElementById("actionTypeXref").style.display = 'none'; 
	break;
	case 'subordinate':
                document.getElementById("actionTypeValueHeader").style.display = 'none'; 
                document.getElementById("actionTypeValue").style.display = 'none'; 
               	document.getElementById("actionTypeLinkHeader").style.display = 'none'; 
               	document.getElementById("actionTypeLink").style.display = 'none'; 
                document.getElementById("actionTypeUserStoryHeader").style.display = ''; 
                document.getElementById("actionTypeUserStory").style.display = ''; 
               	document.getElementById("actionTypeCommentHeader").style.display = 'none'; 
               	document.getElementById("actionTypeComment").style.display = 'none'; 
               	document.getElementById("actionTypeXrefHeader").style.display = 'none'; 
               	document.getElementById("actionTypeXref").style.display = 'none'; 
	break;
	case 'xref':
                document.getElementById("actionTypeValueHeader").style.display = 'none'; 
                document.getElementById("actionTypeValue").style.display = 'none'; 
               	document.getElementById("actionTypeLinkHeader").style.display = 'none'; 
               	document.getElementById("actionTypeLink").style.display = 'none'; 
                document.getElementById("actionTypeUserStoryHeader").style.display = 'none'; 
                document.getElementById("actionTypeUserStory").style.display = 'none'; 
               	document.getElementById("actionTypeCommentHeader").style.display = 'none'; 
               	document.getElementById("actionTypeComment").style.display = 'none'; 
               	document.getElementById("actionTypeXrefHeader").style.display = ''; 
               	document.getElementById("actionTypeXref").style.display = ''; 
	break;
	default:
               	document.getElementById("actionTypeValueHeader").style.display = ''; 
               	document.getElementById("actionTypeValue").style.display = ''; 
               	document.getElementById("actionTypeLinkHeader").style.display = 'none'; 
               	document.getElementById("actionTypeLink").style.display = 'none'; 
                document.getElementById("actionTypeUserStoryHeader").style.display = 'none'; 
                document.getElementById("actionTypeUserStory").style.display = 'none'; 
               	document.getElementById("actionTypeCommentHeader").style.display = 'none'; 
               	document.getElementById("actionTypeComment").style.display = 'none'; 
               	document.getElementById("actionTypeXrefHeader").style.display = 'none'; 
               	document.getElementById("actionTypeXref").style.display = 'none'; 
	}

}
function check_userstoryId() {
    var return_id=false
    var inp02=document.mainform.userstoryId.value
    var inp03=document.mainform.origuserstoryId.value
    if (inp02=="") {
     alert("Field: User Story Id is Mandatory -- please enter")
    } else {
      if (inp02==inp03) {
             return_id=true
      } else {
              if (confirm("Update User Story ID from '"+inp03+"' to '"+inp02+"'?")) {
                      return_id=true
              }
      }
    }
    return return_id
}
function check_userstoryVersion() {
    var return_version=false
    var inp02=document.mainform.userstoryVersion.value
    if (inp02=="") {
     alert("Field: User Story Version is Mandatory -- please enter")
    } else {
	     return_version=true
    }
    return return_version
}
function check_userstoryName() {
    var return_Name=false
    var inp02=document.mainform.userstoryName.value
    var inp03=document.mainform.origuserstoryName.value
    if (inp02=="") {
     alert("Field: User Story Name is Mandatory -- please enter")
    } else {
      if (inp02==inp03) {
             return_Name=true
      } else {
	if (inp03!="") {
              if (confirm("Update Use Case ID from '"+inp03+"' to '"+inp02+"'?")) {
                      return_Name=true
              }
	} else {
                      return_Name=true
	}
      }
    }
    return return_Name
}
function check_valueStatement() {
    var return_goal=false
    var inp02=document.mainform.valueStatement.value
    if (inp02=="") {
     alert("Field: Value Statement is Mandatory -- please enter")
    } else {
     return_goal=true
    }
    return return_goal
}
function check_status() {
    var return_condition=false
    var inp02=document.mainform.status.value
    if (inp02=="") {
     alert("Field: Status is Mandatory -- please enter")
    } else {
     return_condition=true
    }
    return return_condition
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
function chkForm1() {
   varF1C=check_userstoryName();
   if (varF1C==false) {
       document.mainform.userstoryName.focus() ;
       return false ;
   }
   varF1D=check_userstoryVersion();
   if (varF1D==false) {
       document.mainform.userstoryVersion.focus()
       return false
   }
   varF1E=check_valueStatement();
   if (varF1E==false) {
       document.mainform.valueStatement.focus()
       return false
   }
   varF1F=check_status();
   if (varF1F==false) {
       document.mainform.status.focus()
       return false
   }
   varF1G=check_projectId();
   if (varF1G==false) {
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
   <h1>User Story Template <?php echo $rep_name ?></h1>

 <form name="mainform" method="post" ACTION="us_add.php" > 

	<table border=4 cellspacing=0 cellpadding=2 bordercolor=#eeeeee width=850> 


<?

if (!$_GET['usId']) {
	$userstoryPH = '<new>' ;
	$userstoryRO = '' ;
	$userstoryVersion = 0;
	$readoption = '';
} else {
	$userstoryPH = '' ;
	$userstoryRO = 'readonly' ;
	$userstoryId = $_GET['usId'] ;

	$readoption = 'readonly';
	$showMulti = 1;

	$presql = "select * from user_story where userstoryid = '".$userstoryId."'  ";
	$preresult = execSql($db, $presql, $debug) ;
/* herehere */
        	list ($usId, $userstoryVersion, $userstoryName, $valueStatement, $status, $iteration, $planEstimate, $toDo, $owner, $statusdate, $createdBy, $usTier,$projectId) = pg_fetch_row($preresult, 0);

}
?>


<tr>
<td> <b>ID:</b></td><td>
    <input type="hidden" name="origuserstoryId" value="<?php echo $userstoryId ?>"> 
    <input type="text" id="userstoryId" name="userstoryId" size="10" maxlength="10" readonly placeholder="<?php echo $userstoryPH ?>" <?php echo $userstoryRO ?> value="<?php echo $userstoryId ?>"></td>
<td> <b>Version:</b></td><td>
    <input type="text" id="userstoryVersion" name="userstoryVersion" size="10" maxlength="10" value="<?php echo $userstoryVersion ?>"></td>
<td> <b>Name:</b></td><td>
    <input type="hidden" name="origuserstoryName" value="<?php echo $userstoryName ?>"> 
    <input type="text"  name="userstoryName" value="<?php echo $userstoryName ?>"  size="25" maxlength="70"></td>
</tr>
<tr>
<td colspan=8>&nbsp;</td>
</tr>
<tr>
<td> <b>Value Statement:</b></td><td colspan=7><TEXTAREA name="valueStatement" rows="6" cols="130" placeholder="As a(n) <type of user>, I want <some goal> so that <some reason>"><?php echo $valueStatement ?></textarea>
</td>
</tr>
<tr>
<td colspan=8>&nbsp;</td>
</tr>
<tr>
<?
	$sql = "select  action_value, action_inc from user_story_action where userstoryid = '".$userstoryId."' and action_type = 'acceptance' order by action_inc ";

	$relationship_all = execSql ($db, $sql, $debug);
	$pre_rows = pg_num_rows($relationship_all) ;
	$bordervalue = $pre_rows > 0 ? 1 : 0;
	echo "<td> Acceptance Criteria:</td><td colspan=7><table border=".$bordervalue.">";
			$rownum = 0;
				while ($relationship_row = pg_fetch_array($relationship_all, $rownum)) {
  					$item_value = $relationship_row["action_value"];
  					$item_inc = $relationship_row["action_inc"];
				echo '<tr><td><a onclick="window.open(\'us_action_form.php?usId='.$userstoryId.'&at=acceptance&ac='.$item_inc.'\',\'name\',\'width=800,height=600\')">'.$item_inc.'</a></td><td colspan=50 >'.$item_value.'</td></tr>';
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
<?
	$sql = "select action_value, action_inc from user_story_action where userstoryid = '".$userstoryId."' and action_type = 'donedef' order by action_inc ";
	$relationship_all = execSql ($db, $sql, $debug);
	$act_rows = pg_num_rows($relationship_all) ;
	$bordervalue = $act_rows > 0 ? 2 : 0;
	echo "<td> Definition of Done:</td><td colspan=7><table border=".$bordervalue.">";
			$rownum = 0;
				while ($relationship_row = pg_fetch_array($relationship_all, $rownum)) {
  					$item_value = $relationship_row["action_value"];
  					$item_inc = $relationship_row["action_inc"];
				echo '<tr><td><a onclick="window.open(\'us_action_form.php?usId='.$userstoryId.'&at=donedef&ac='.$item_inc.'\',\'name\',\'width=800,height=600\')">'.$item_value.'</a></td></tr>';
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
<td> Status:</td><td>
<?
  		echo '<select name="status">';
 		echo '<option value="'.$no_prelationship.'" >'.$no_prelationship.'</option>';
 
  			$relationship_all = pg_exec($db,"SELECT item_cd, item_description from app_lookup where lookup_table = 'user_story_action' and lookup_field = 'status' order by sort_order "); 
			$rownum = 0;
				while ($relationship_row = pg_fetch_array($relationship_all, $rownum)) {
  					$item_description = $relationship_row["item_description"];
  					$item_cd = $relationship_row["item_cd"];
					$rownum = $rownum + 1;
					if ($item_cd == $status) {
  					echo "<option selected value='$item_cd'>".$item_cd." - ".$item_description."</option>";
					} else {
  					echo "<option value='$item_cd'>".$item_cd." - ".$item_description."</option>";
					}
  				}
  		echo "</select></td>";
?>


<td> Tier:</td><td>
<?
  		echo '<select name="usTier">';
  			$relationship_all = pg_exec($db,"SELECT item_cd, item_description from app_lookup where lookup_table = 'generic' and lookup_field = 'tier' order by sort_order "); 
			$rownum = 0;
				while ($relationship_row = pg_fetch_array($relationship_all, $rownum)) {
  					$item_description = $relationship_row["item_description"];
  					$item_cd = $relationship_row["item_cd"];
					$rownum = $rownum + 1;
					if ($item_cd == $usTier) {
  					echo "<option selected value='$item_cd'>".$item_cd." - ".$item_description."</option>";
					} else {
  					echo "<option value='$item_cd'>".$item_cd." - ".$item_description."</option>";
					}
  				}
  		echo "</select></td>";
echo "<td> Project Id:</td><td>";
  		echo '<select name="projectId">';
  			$relationship_all = pg_exec($db,"SELECT projectid, project_name from project where projectid in (select projectid from project_user where employee_id = '".$_SESSION['userid']."') order by 2 "); 
			$rownum = 0;
				while ($relationship_row = pg_fetch_array($relationship_all, $rownum)) {
  					$item_description = $relationship_row["project_name"];
  					$item_cd = $relationship_row["projectid"];
					$rownum = $rownum + 1;
					if ($item_cd == $projectId) {
  					echo "<option selected value='$item_cd'>".$item_description."</option>";
					} else {
  					echo "<option value='$item_cd'>".$item_description."</option>";
					}
  				}
  		echo "</select></td>";

echo "</tr>";
/*
<tr>
<td> Plan Estimate:</td><td>
    <input type="text" id="planEstimate" name="planEstimate" value="<?php echo $planEstimate ?>"  size="10" maxlength="10" ></td>
<td> To Do:</td><td>
    <input type="text"  name="toDo" value="<?php echo $toDo ?>"  size="10" maxlength="10"></td>
</tr>
*/

?>

</td>
</tr>
<tr>
<td colspan=8>&nbsp;</td>
</tr>

<tr>
<?
        $sql = "select us.action_value, u.userstoryname, us.action_inc, us.userstoryid from user_story_action us, user_story u where us.userstoryid = u.userstoryid and us.action_value = '".$userstoryId."' and us.action_type = 'subordinate' order by us.action_value ";
        // $sql = "select action_value, action_inc from user_story_action where action_value = '".$userstoryId."' and action_type = 'subordinate' order by action_value ";
        $relationship_all = execSql ($db, $sql, $debug);
        $sup_rows = pg_num_rows($relationship_all) ;
        $bordervalue = $sup_rows > 0 ? 2 : 0;
        echo "<td> Superordinates:</td><td colspan=7><table border=".$bordervalue.">";
                        $rownum = 0;
                                while ($relationship_row = pg_fetch_array($relationship_all, $rownum)) {
                                        $item_ref = $relationship_row["userstoryid"];
                                        $item_name = $relationship_row["userstoryname"];
                                        $item_value = $relationship_row["action_value"];
                                        $item_inc = $relationship_row["action_inc"];
                                echo '<tr><td><a onclick="window.open(\'us_action_form.php?usId='.$item_ref.'&at=subordinate&ac='.$item_inc.'\',\'name\',\'width=1200,height=600\')">'.$item_inc.'</a></td>';
                                echo '<td colspan=50 ><a onclick="window.open(\'us_form.php?usId='.$item_ref.'\',\'name\',\'width=1200,height=800\')">'.$item_ref.'</a></td>';
                                echo '<td>'.$item_name.'</td></tr>';

                                        $rownum = $rownum + 1;
                                }
echo "</table>";
echo "</td>";
echo "</tr>";

echo "<tr>";

        $sql = "select us.action_value, u.userstoryname, us.action_inc from user_story_action us, user_story u where us.action_value = u.userstoryid and us.userstoryid = '".$userstoryId."' and us.action_type = 'subordinate' order by us.action_value ";

        $relationship_all = execSql ($db, $sql, $debug);
        $sup_rows = pg_num_rows($relationship_all) ;
        $bordervalue = $sup_rows > 0 ? 2 : 0;
        echo "<td> Subordinates:</td><td colspan=7><table border=".$bordervalue.">";
                        $rownum = 0;
                                while ($relationship_row = pg_fetch_array($relationship_all, $rownum)) {
                                        $item_name = $relationship_row["userstoryname"];
                                        $item_value = $relationship_row["action_value"];
                                        $item_inc = $relationship_row["action_inc"];
                                echo '<tr><td><a onclick="window.open(\'us_action_form.php?usId='.$userstoryId.'&at=subordinate&ac='.$item_inc.'\',\'name\',\'width=800,height=600\')">'.$item_inc.'</a></td>';
                                echo '<td colspan=50 ><a onclick="window.open(\'us_form.php?usId='.$item_value.'\',\'name\',\'width=1200,height=800\')">'.$item_value.'</a></td>';
                                echo '<td>'.$item_name.'</td></tr>';
                                        $rownum = $rownum + 1;
                                }
echo "</table>";
echo "</td>";
echo "</tr>";

 echo "<tr><td colspan=6>&nbsp;</td></tr>";

echo "<tr>";

        $sql = "select action_value, action_inc from user_story_action where userstoryid = '".$userstoryId."' and action_type = 'link' order by action_value ";
        $relationship_all = execSql ($db, $sql, $debug);
        $sup_rows = pg_num_rows($relationship_all) ;
        $bordervalue = $sup_rows > 0 ? 2 : 0;
        echo "<td> Links:</td><td colspan=7><table border=".$bordervalue.">";
                        $rownum = 0;
                                while ($relationship_row = pg_fetch_array($relationship_all, $rownum)) {
                                        $item_value = $relationship_row["action_value"];
                                        $item_inc = $relationship_row["action_inc"];
                                echo '<tr><td><a onclick="window.open(\'us_action_form.php?usId='.$usecaseId.'&at=subordinate&ac='.$item_inc.'\',\'name\',\'width=800,height=600\')">'.$item_inc.'</a></td><td colspan=50 >'.$item_value.'</td></tr>';
                                        $rownum = $rownum + 1;
                                }
echo "</table>";
echo "</td>";
echo "</tr>";

echo "<tr>";

        $sql = "select us.action_value, u.usecasename, us.action_inc from user_story_action us, use_case u where us.action_value = u.usecaseid and us.userstoryid = '".$userstoryId."' and us.action_type = 'xref' order by us.action_value ";
        $relationship_all = execSql ($db, $sql, $debug);
        $sup_rows = pg_num_rows($relationship_all) ;
        $bordervalue = $sup_rows > 0 ? 2 : 0;
        echo "<td> Cross References:</td><td colspan=7><table border=".$bordervalue.">";
                        $rownum = 0;
                                while ($relationship_row = pg_fetch_array($relationship_all, $rownum)) {
                                        $item_name = $relationship_row["usecasename"];
                                        $item_value = $relationship_row["action_value"];
                                        $item_inc = $relationship_row["action_inc"];
                                echo '<tr><td><a onclick="window.open(\'us_action_form.php?usId='.$item_value.'&at=xref&ac='.$item_inc.'\',\'name\',\'width=1200,height=600\')">'.$item_name.'</a></td><td colspan=50 >'.$item_value.'</td></tr>';
                                        $rownum = $rownum + 1;
                                }
echo "</table>";
echo "</td>";
echo "</tr>";
 echo "<tr><td colspan=6>&nbsp;</td></tr>";

echo "<br>";

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



 echo "<tr><td colspan=6>&nbsp;</td></tr>";
 echo "<tr>";

	$sql = "select doc_type, doc_name, doc_dir, document_description from user_story_document where userstoryid = '".$userstoryId."' order by doc_name "; 
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

</table>
    </p>
  </form>
</blockquote>
<?

include "inc/footer_inc.php";
?>
</body>
</HTML>
