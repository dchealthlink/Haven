<?php
session_start();
include "inc/dbconnect.php";
$show_menu="ON";
include("inc/index_header_inc.php");
/*
if (session_is_registered("search_where")) {
        $search_where = "";
}
*/
/*
if(!session_is_registered("ownerid"))
{
header("Location: index.htm");
exit;
}
*/
?>
<html>

  Available Selections:

<br>
<tr><td>
	<table border=0 cellspacing=0 cellpadding=2 bordercolor=#eeeeee width=720> 
    <tr><td colspan=2 align=center><b>Application Options</b> </td></tr>
<?php


$sql = "SELECT item_cd, item_description, item_translation FROM app_lookup WHERE lookup_table = 'application_menu' AND (lookup_field = '".$usertype."' or lookup_field = 'ALL') ORDER BY sort_order ";

$result = execSql($db, $sql, $debug);
    
$rownum = 0;
        while ($row = pg_fetch_array($result,$rownum))
        {
                list($t_item_cd, $t_item_description, $t_item_translation) = pg_fetch_row($result,$rownum);
                echo "<tr><td align=center><b><a href='".$t_item_translation."'>".$t_item_cd."</a></b></td><td>".$t_item_description."</td></tr>";
        $rownum = $rownum + 1;
        }



?>
    <tr><td align=center><b>---------------</a></b></td><td align=left>------------------------------</td></tr>
    <tr><td colspan=2 align=center><b>Additional Options</b> </td></tr>
    <tr><td align=center><b>Search Applications</b></td><td>Search Application Information</td></tr>




    </table>


<table>
<?php
 echo "<tr><td>";
 echo "Please Enter Data to Search For</td></tr>";
 echo "<tr><td>All Selections will be <em>Logically Anded</em> (e.g. First Name = 'Bill' AND Last Name = 'Smith')</td></tr>";
 echo "<FORM NAME=mainform METHOD=post ACTION=search_application_gen.php onSubmit='return ValidateForm()'>";
 echo "<tr><td valign=top>";
 echo "<table>";
 echo "<tr><td colspan=6><B>Application Information:</B></td></tr>";
 echo "<tr><td>Person ID:</td><td><input class=pink type=text name=person_id maxlength=16 size=20></td>";
 echo "<td>Application Year:</td><td>";
$emsql = "SELECT item_cd, item_description from app_lookup WHERE lookup_table = 'generic' and lookup_field = 'appyear'";

$emresult = execSql($db, $emsql, $debug);

        echo"<select name=\"appYear\">";
        echo"<option selected value=\"\">";
        $em_rownum=0;

while ($row = pg_fetch_array($emresult,$em_rownum))
{
        list($user_type, $user_type_desc) = pg_fetch_row($emresult,$em_rownum);
        if ($user_type == $employee_type ) {
                echo "<option value=".$user_type." SELECTED>".$user_type_desc;
        } else {
                echo "<option value=".$user_type.">".$user_type_desc;
        }
        $em_rownum = $em_rownum + 1;
}

 echo "</td></tr>";



 echo "<tr><td>First Name:</td><td><input class=pink type=text name=first_name maxlength=40 size=25></td>";
 echo "<td>Last Name:</td><td><input class=pink type=text name=last_name maxlength=40 size=25></td></tr>";
 echo "<tr><td>Application Name:</td><td colspan=3><input class=pink type=text name=applname maxlength=80 size=50></td>";

 echo "<tr><td>Status:</td><td>";
$esql = "SELECT distinct status FROM employee ORDER BY 1 ";

$eresult = execSql($db, $esql, $debug);

        echo"<select name=\"status\">";
        echo"<option selected value=\"\">";
        $e_rownum=0;

while ($row = pg_fetch_array($eresult,$e_rownum)) {
        list($temp_pay_rule_cd) = pg_fetch_row($eresult,$e_rownum);
        if ($temp_pay_rule_cd == $status) {
                echo "<option value=".$temp_pay_rule_cd." SELECTED>".$temp_pay_rule_cd;
        } else {
                echo "<option value=".$temp_pay_rule_cd." >".$temp_pay_rule_cd;
        }
        $e_rownum = $e_rownum + 1;
}

 echo "</select></td>";


 echo "<td>State:</td><td>";
$desql = "SELECT state, state_name FROM states order by sort_order ";

$deresult = execSql($db, $desql, $debug);

        echo"<select name=\"statecd\">";
        echo"<option selected value=\"\">";
        $de_rownum=0;

while ($row = pg_fetch_array($deresult,$de_rownum))
{
        list($temp_department_id, $temp_department_name) = pg_fetch_row($deresult,$de_rownum);
        if ($temp_department_id == $department_id) {
                echo "<option value=".$temp_department_id." SELECTED>".$temp_department_name;
        } else {
                echo "<option value=".$temp_department_id.">".$temp_department_name;
        }
        $de_rownum = $de_rownum + 1;
}

 echo "</select></td></tr>";

 echo "<tr><td>From Date:</td><td><input class=pink type=text name=from_date maxlength=15 size=12 onChange=BisDate(this,'n') > </td>";
 echo "<td>To Date:</td><td><input class=pink type=text name=to_date maxlength=15 size=12 onChange=BisDate(this,'n') ></td></tr>";

 echo "<tr><td>&nbsp</td></tr>";
?>

          <tr><td colspan=8>
    <input class="gray" type="Submit" name="SEARCHVENDOR" value="Search">&nbsp;
    <input class="gray" type="reset" name="RESET" value="Reset">
        </td></tr>




	</td></tr>

</body>
</table>
</table>
<?
include "inc/footer_inc.php";
?>

</HTML>

