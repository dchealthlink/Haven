<?php
session_start();
include "inc/mnconnect.php";
if ($DELETE) { 
	$delsql = "DELETE from user_story_action WHERE userstoryid = '".$_POST['usId']."' and action_type = '".$_POST['at']."' and action_inc = ".$_POST['ac'];
	$result = execSql($db, $delsql, $debug) ;

?>
<script>
    window.opener.location.reload();
    window.close();
</script>
<?php


}
if ($UPDATE){

	$updsql = "UPDATE user_story_action SET action_value = '".$_POST['actionValue']."',  owner = '".$_SESSION['userid']."', action_userstoryid = '".$_POST['actionUserStoryId']."' , status_timestamp = now(), comments = '".$comments."' WHERE userstoryid = '".$_POST['usId']."' and action_type = '".$_POST['at']."' and action_inc = ".$_POST['ac'];
	$result = execSql($db, $updsql, $debug) ;
?>
<script>
    window.opener.location.reload();
    window.close();
</script>
<?php
}

$show_menu = "OFF";
include("inc/index_header_inc.php");

?>
<html>
<head>
<script language = "Javascript">

function submitenter(myfield,event)
{
        if(event.which) 
                mykey = event.which;
        else  
                mykey = event.keyCode;
        // if chr(13) a.k.a ENTER is pressed

	        if (mykey=="13") {
			mainform.SUBMIT.focus();
			return false;
		}
	
}
function cursor(){
	document.mainform.finance_amount.focus();
}
</script>
</head>
<body onunload="window.opener.reload();">
<?

if (!$payments_per_year) {
	$payments_per_year = 12;
}
if ($interest_rate == null) {
	$interest_rate = 0;
}
if ($down_payment_amount == null) {
	$down_payment_amount = 0;
}


$sql = "SELECT a.userstoryid, u.userstoryname, a.action_type, a.action_inc, a.action_value, a.owner, e.first_name||' '||e.last_name, a.status_timestamp, a.action_userstoryid, comments from user_story_action a, user_story u, employee e  WHERE a.userstoryid = u.userstoryid and a.owner = e.employee_id and a.userstoryid = '".$_GET['usId']."' and a.action_type = '".$_GET['at']."' and a.action_inc = ".$_GET['ac'] ;

$result = execSql($db, $sql, $debug);
list ($ucid, $ucname, $actiontype, $actioninc, $actionvalue, $owner, $ownername, $statustimestamp, $actionUserStoryId, $comments) = pg_fetch_row($result, 0);

echo "<tr>";
echo "<td>";

echo "User: <b>".$temp_cashier_id." - ".$username."</b>";

echo "   Date: <b>".date('l F dS, Y h:i:s A')."</b>";

echo "<br>";
echo "<FORM NAME=mainform METHOD=post ACTION=".$PHP_SELF." onSubmit=\"return ValidateForm()\">";

/* ============ end submit ============ */

echo "<table><tr><td>&nbsp;";

echo "</td>";
echo "<table>";

echo "<tr>";
echo "<td>User Story ID:";
echo "</td><td>";
echo "<input type=text name=userstoryId maxlength=58 size=30 readonly value='".$ucid.' - '.$ucname."'>";  
echo "</td></tr>";

echo "<tr>";
echo "<td>Action Type:";
echo "</td><td>";
echo "<input type=text name=actionType maxlength=18 size=20 readonly value='".$actiontype."'>";  
echo "</td></tr>";

echo "<tr>";
echo "<td>Increment:";
echo "</td><td>";
echo "<input type=text name=actionInc maxlength=18 size=20 readonly value='".$actioninc."'>";  
echo "</td></tr>";

echo "<td>";
switch ($at) {
	case 'superordinate':
	case 'subordinate':
		echo "User Story:";
		echo "</td><td>";
                echo '<select name="actionValue">';
                echo '<option value=></option>';

	        $sql = "select userstoryid, userstoryname from  user_story where userstoryid != '".$_GET['usId']."'  ORDER by 2 ";


        $relationship_all = execSql ($db, $sql, $debug);
        $sup_rows = pg_num_rows($relationship_all) ;
                        $rownum = 0;
                                while ($relationship_row = pg_fetch_array($relationship_all, $rownum)) {
                                        $item_description = $relationship_row["userstoryname"];
                                        $item_cd = $relationship_row["userstoryid"];
                                        if ($item_cd == $actionvalue) {
                                        echo "<option selected value='$item_cd'>".$item_cd." - ".$item_description."</option>";
                                        } else {
                                        echo "<option value='$item_cd'>".$item_cd." - ".$item_description."</option>";
                                        }



                                        $rownum = $rownum + 1;
                                }

	break;
	case 'xref':
		echo "Use Case:";
		echo "</td><td>";
                echo '<select name="actionValue">';
                echo '<option value=></option>';

	        $sql = "select usecaseid, usecasename from  use_case where usecaseid != '".$_GET['usId']."'  ORDER by 2 ";
	        $sql = "select usecaseid, usecasename from  use_case   ORDER by 2 ";


        $relationship_all = execSql ($db, $sql, $debug);
        $sup_rows = pg_num_rows($relationship_all) ;
                        $rownum = 0;
                                while ($relationship_row = pg_fetch_array($relationship_all, $rownum)) {
                                        $item_description = $relationship_row["usecasename"];
                                        $item_cd = $relationship_row["usecaseid"];
                                        if ($item_cd == $actionvalue) {
                                        echo "<option selected value='$item_cd'>".$item_cd." - ".$item_description."</option>";
                                        } else {
                                        echo "<option value='$item_cd'>".$item_cd." - ".$item_description."</option>";
                                        }



                                        $rownum = $rownum + 1;
                                }

	break;
	default:
		echo "Action:";
		echo "</td><td>";
		echo "<TEXTAREA name=actionValue rows=7 cols=70>".$actionvalue."</textarea>";  
}
echo "</td>";
echo "</tr>";
echo "<tr>";

echo "<td>";
echo "Last Modified By:";
echo "</td><td>";
echo "<input type=text name=owner readonly maxlength=57 size=50 value='".$owner.' - '.$ownername."'>";  
echo "</td>";

echo "<tr>";

echo "<td>";
echo "Timestamp:";
echo "</td><td>";
echo "<input type=text name=statusTimestamp maxlength=25 size=25 readonly value='".$statustimestamp."'>";  
echo "</td>";
?>

</tr> 
<tr><td colspan=8>&nbsp;</td></tr>
<tr><td colspan=2>
<INPUT TYPE=SUBMIT NAME=UPDATE VALUE=Update ONCLICK="document.all.whichbutton.value = this.value; submit;">&nbsp;
<INPUT TYPE=SUBMIT NAME=DELETE VALUE=Delete ONCLICK="document.all.whichbutton.value = this.value; submit;">&nbsp;
<input type=Button name=CLOSEWINDOW value="Close Window" onClick="window.close()">
<input type=RESET name=formReset value=Reset></td>

<input type="hidden" name="tablename" value="<?php echo $header_table ?>">
<input type="hidden" name="whichbutton" value="none" >
<input type="hidden" name="usId" value="<?php echo $_GET['usId'] ?>" >
<input type="hidden" name="at" value="<?php echo $_GET['at'] ?>" >
<input type="hidden" name="ac" value="<?php echo $_GET['ac'] ?>" >



<?

/* =========================== */
echo "</td></tr>"; 
echo "</table>";
?>
</form>
</table>
</body>
</HTML>


