<?php
session_start();
include "inc/mnconnect.php";
if ($DELETE) { 
	$delsql = "DELETE from use_case_action WHERE usecaseid = '".$_POST['ucId']."' and action_type = '".$_POST['at']."' and action_inc = ".$_POST['ac'];
	$result = execSql($db, $delsql, $debug) ;

?>
<script>
    window.opener.location.reload();
    window.close();
</script>
<?php


}
if ($UPDATE){

	$updsql = "UPDATE use_case_action SET action_value = '".$_POST['actionValue']."', action_step = '".$_POST['actionStep']."', actor = '".$_POST['actor']."' , owner = '".$_SESSION['userid']."', statustimestamp = now() WHERE usecaseid = '".$_POST['ucId']."' and action_type = '".$_POST['at']."' and action_inc = ".$_POST['ac'];
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


$sql = "SELECT a.usecaseid, u.usecasename, a.action_type, a.action_inc, a.action_step, a.action_value, a.actor, a.owner, e.first_name||' '||e.last_name, a.statustimestamp from use_case_action a, use_case u, employee e  WHERE a.usecaseid = u.usecaseid and a.owner = e.employee_id and a.usecaseid = '".$_GET['ucId']."' and a.action_type = '".$_GET['at']."' and a.action_inc = ".$_GET['ac'] ;

$result = execSql($db, $sql, $debug);
list ($ucid, $ucname, $actiontype, $actioninc, $actionstep, $actionvalue, $actor, $owner, $ownername, $statustimestamp) = pg_fetch_row($result, 0);

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
echo "<td>Use Case ID:";
echo "</td><td>";
echo "<input type=text name=usecaseId maxlength=58 size=30 readonly value='".$ucid.' - '.$ucname."'>";  
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

echo "<tr>";
echo "<td>Step:*";
echo "</td><td>";
echo "<input type=text name=actionStep maxlength=8 size=10 value=".$actionstep.">";  
echo "</td>";
echo "</tr>";
echo "<tr>";

echo "<td>";
switch ($at) {
	case 'superordinate':
	case 'subordinate':
		echo "Use Case:";
		echo "</td><td>";
                echo '<select name="actionValue">';
                echo '<option value=></option>';

	        $sql = "select usecaseid, usecasename from  use_case WHERE usecaseid != '".$_GET['ucId']."' ORDER by 2 ";


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

$irsql = "SELECT actor FROM actor_type  ORDER BY 1";
$irresult = execSql($db, $irsql, $debug) ;

echo "<td>";
echo "Actor:";
echo "</td><td>";

        echo"<select name=\"actor\">";
        echo"<option selected value=\"\">";
        $ir_rownum=0;

        while ($row = pg_fetch_array($irresult,$ir_rownum)) {
                list($t_cd, $t_desc) = pg_fetch_row($irresult,$ir_rownum);
                if ($t_cd == $actor) {
                        echo "<option SELECTED value=".$t_cd.">".$t_cd;
                } else {
                        echo "<option value=".$t_cd.">".$t_cd;
                }
                $ir_rownum = $ir_rownum + 1;
        }
echo "</SELECT></td>";

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
<input type="hidden" name="ucId" value="<?php echo $_GET['ucId'] ?>" >
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


