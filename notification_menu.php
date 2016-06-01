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

?>
<html>

  Available Selections:

<br>
<tr><td>
	<table border=0 cellspacing=0 cellpadding=2 bordercolor=#eeeeee width=720> 
    <tr><td colspan=2 align=center><b>Notification Options</b> </td></tr>

<?php
$sql = "SELECT item_cd, item_description, item_translation FROM app_lookup WHERE lookup_table = 'notification_menu' AND lookup_field = '".$usertype."' ORDER BY sort_order ";

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
    <tr><td align=center><b>Search Notification</b></td><td>Search Notification Information</td></tr>




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


 echo "<tr><td>City:</td><td><input class=pink type=text name=city maxlength=40 size=35></td>";
 echo "<td>State:</td><td>";
$stsql = "SELECT item_cd, item_description FROM app_lookup WHERE lookup_table = 'employee' AND lookup_field = 'state' ORDER BY 2";

$stresult = execSql($db, $stsql, $debug);
 
        echo"<select name=\"state\">";
        echo"<option selected value=\"\">";
        $st_rownum=0;
 
while ($row = pg_fetch_array($stresult,$st_rownum))
{
        list($item_cd, $item_description) = pg_fetch_row($stresult,$st_rownum);
        if ($item_cd == $state) {
                echo "<option value=".$item_cd." SELECTED>".$item_description;
        } else {
                echo "<option value=".$item_cd.">".$item_description;
        }
        $st_rownum = $st_rownum + 1;
}

 echo "</td></tr>";


 echo "<tr><td>Supervisor Id:</td><td><input class=pink type=text name=supervisor_id maxlength=20 size=20></td>";
 echo "<td>Department Id:</td><td>";
$desql = "SELECT department_id, department_name FROM department ORDER BY 2";

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

 echo "</td></tr>";


 echo "<tr><td>&nbsp</td></tr>";
/*
 echo "<tr><td colspan=6><B>Contact Information:</B></td></tr>"; 
 echo "<td>First Name: </td><td><input class=pink type=text name=vc_first_name maxlength=20 size=15></td>";
 echo "<td>Last Name: </td><td><input class=pink type=text name=vc_last_name maxlength=30 size=20></td></tr>";
 echo "<td>Contact Id: </td><td><input class=pink type=text name=vc_id maxlength=15 size=12></td>";
 echo "<td>Phone: </td><td><input class=pink type=text name=vc_phone maxlength=30 size=20></td></tr>";
 echo "<tr><td>Email: </td><td colspan=2><input class=pink type=text name=email maxlength=50 size=40></td>";
 echo "<tr><td>Contact Type:</td><td><input class=pink type=text name=vc_type maxlength=2 size=3 value=".$vc_type."></td></tr>";

 echo "<tr><td>&nbsp</td></tr>";

 echo "<tr><td colspan=6><B>Location Information:</B></td></tr>";

 echo "<tr><td>Location ID:</td><td><input class=pink type=text name=vl_id maxlength=16 size=20></td>";
 echo "<td>Location Name:</td><td><input class=pink type=text name=vl_name maxlength=40 size=35></td></tr>";
 echo "<tr><td>Employee Type:</td><td><input class=pink type=text name=vl_type maxlength=40 size=35></td>";
 echo "<td>Location Alt Name:</td><td><input class=pink type=text name=vl_alt_name maxlength=40 size=35></td></tr>";
 echo "<td>City: </td><td><input class=pink type=text name=vc_city maxlength=20 size=15></td>";
 echo "<td>State: </td><td><input class=pink type=text name=vc_state maxlength=2 size=3></td></tr>";
 echo "<td>Zip Code: </td><td><input class=pink type=text name=vc_zip_code maxlength=10 size=12></td>";
*/
?>

          <tr><td colspan=8>
    <input class="gray" type="Submit" name="SEARCHVENDOR" value="Search">&nbsp;
    <input class="gray" type="reset" name="RESET" value="Reset">
        </td></tr>




	</td></tr>
</table>
</table>

</body>
<?
include "inc/footer_inc.php";
?>
</table>
</HTML>

