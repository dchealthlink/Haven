<?
session_start();
include "inc/dbconnect.php";
$show_menu="ON";
include("inc/index_header_inc.php");
if ($_SESSION['seach_where']) {
        $_SESSION['search_where'] = "";
}

?>
<html>

  Available Selections:

<br>
<tr><td>
	<table border=0 cellspacing=0 cellpadding=2 bordercolor=#eeeeee width=720> 
    <tr><td colspan=2 align=center><b>Employee Options</b> </td></tr>
<?php


$sql = "SELECT item_cd, item_description, item_translation FROM app_lookup WHERE lookup_table = 'employee_menu' AND (lookup_field = '".$usertype."' or lookup_field = 'ALL') ORDER BY sort_order ";

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
    <tr><td align=center><b>Search Employees</b></td><td>Search Employee Information</td></tr>




    </table>


<table>
<?php
 echo "<tr><td>";
 echo "Please Enter Data to Search For</td></tr>";
 echo "<tr><td>All Selections will be <em>Logically Anded</em> (e.g. First Name = 'Bill' AND Last Name = 'Smith')</td></tr>";
 echo "<FORM NAME=mainform METHOD=post ACTION=search_employee_gen.php onSubmit='return ValidateForm()'>";
 echo "<tr><td valign=top>";
 echo "<table>";
 echo "<tr><td colspan=6><B>Employee Information:</B></td></tr>";
 echo "<tr><td>Employee ID:</td><td><input class=pink type=text name=employee_id maxlength=16 size=20></td>";
 echo "<td>Employee Type:</td><td>";
$emsql = "SELECT user_type, user_type_desc FROM user_type ORDER BY 2";

$emresult = execSql($db, $emsql, $debug);

        echo"<select name=\"employee_type\">";
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



 echo "<tr><td>First Name:</td><td><input class=pink type=text name=first_name maxlength=40 size=35></td>";
 echo "<td>Last Name:</td><td><input class=pink type=text name=last_name maxlength=40 size=35></td></tr>";

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


 echo "<td>Department Id:</td><td>";
$desql = "SELECT department_id, department_name FROM department ";

switch ($usertype) {
        case "user":
        case "supervisor":
                $df_sql = "SELECT department_id FROM employee WHERE employee_id = '".$key_value."'";
                $df_result = execSql($db, $df_sql, $debug);
                list ($search_department_id) = pg_fetch_row ($df_result,0);
                $desql.=" WHERE department_id = '".$search_department_id."'";
                break;
        case "admin":
                $desql.=" WHERE department_id IN (SELECT department_id FROM department_admin WHERE employee_id = '".$key_value."') ";
                break;
        case "su";
                break;
        }

$desql.= " ORDER BY 2";

$deresult = execSql($db, $desql, $debug);

        echo"<select name=\"department_id\">";
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

 echo "<tr><td>From Date:</td><td><input class=pink type=text name=from_date maxlength=15 size=12></td>";
 echo "<td>To Date:</td><td><input class=pink type=text name=to_date maxlength=15 size=12></td></tr>";

 echo "<tr><td>Date Type:</td><td>";
        echo"<select name=\"date_type\">";
        echo"<option selected value=hire_date>Hire Date";
        echo"<option selected value=term_date>Termination Date";
 echo "</select></td></tr>";

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

