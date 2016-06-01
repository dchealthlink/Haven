<?php
session_start();
include "inc/dbconnect.php";
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
	<table border=0 width=720>
<tr><td width=500 colspan=6 align=center><table border=0>
    <tr><td colspan=2 align=center><b>User Story Options</b> </td></tr>
<?php


$sql = "SELECT item_cd, item_description, item_translation FROM app_lookup WHERE lookup_table = 'us_menu' AND (lookup_field = '".$usertype."' or lookup_field = 'ALL') ORDER BY sort_order ";

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
    <tr><td align=center><b>Search User Stories</b></td><td>Search User Story Information</td></tr>

</table></td></tr>




<?php
 echo "<tr><td colspan=12>";
 echo "Please Enter Data to Search For</td></tr>";
 echo "<tr><td colspan=12>All Selections will be <em>Logically Anded</em> (e.g. First Name = 'Bill' AND Last Name = 'Smith')</td></tr>";
 echo "<FORM NAME=mainform METHOD=post ACTION=search_us_gen.php onSubmit='return ValidateForm()'>";
 echo "<tr><td valign=top>";
 echo "<tr><td colspan=6><B>User Story Information:</B></td></tr>";

 echo "<tr>";
 echo "<td>User Story ID:</td>";
 echo "<td><input class=pink type=text name=userstoryId maxlength=20 size=15></td>";
 echo "<td>User Story Name:</td>";
 echo "<td><input class=pink type=text name=userstoryName maxlength=70 size=35></td>";
 echo "</tr>";

 echo "<tr>";
 echo "<td>Status:</td>";

$csql ="SELECT item_cd, item_description from app_lookup where lookup_table = 'user_story_action' and lookup_field = 'status' ORDER BY 1";

$cresult = execSql($db,$csql,$debug);

        echo"<td><select name=\"status\">";
        echo"<option selected value=\"\">";

        $c_rownum=0;

while ($row = pg_fetch_array($cresult,$c_rownum))
{
        list($temp_pid, $temp_desc) = pg_fetch_row($cresult,$c_rownum);
        if ($temp_pid == $priority) {
                echo "<option selected value='".$temp_pid."'>".$temp_pid." - ".$temp_desc;
        } else {
                echo "<option value='".$temp_pid."'>".$temp_pid." - ".$temp_desc;
        }
        $c_rownum = $c_rownum + 1;
}
echo "</select></td>";

 echo "</tr>";
 echo "<tr>";
 echo "<td>User Story Tier:</td>";

$csql ="SELECT distinct us_tier from user_story where us_tier is not null ORDER BY 1";
$cresult = execSql($db,$csql,$debug);

        echo"<td><select name=\"us_tier\">";
        echo"<option selected value=\"\">";

        $c_rownum=0;

while ($row = pg_fetch_array($cresult,$c_rownum))
{
        list($temp_pid, $temp_desc) = pg_fetch_row($cresult,$c_rownum);
        if ($temp_pid == $us_tier) {
                echo "<option selected value='".$temp_pid."'>Tier ".$temp_pid;
        } else {
                echo "<option value='".$temp_pid."'>Tier ".$temp_pid;
        }
        $c_rownum = $c_rownum + 1;
}
echo "</select></td>";

 echo "<td>Project:</td>";

$csql ="SELECT projectid, project_name from project WHERE projectid in (select projectid from project_user WHERE employee_id = '".$_SESSION['userid']."') ORDER BY 2";

$cresult = execSql($db,$csql,$debug);

        echo"<td><select name=\"projectid\">";
        echo"<option selected value=\"\">";

        $c_rownum=0;

while ($row = pg_fetch_array($cresult,$c_rownum))
{
        list($temp_pid, $temp_desc) = pg_fetch_row($cresult,$c_rownum);
        if ($temp_pid == $projectid) {
                echo "<option selected value='".$temp_pid."'>".$temp_desc;
        } else {
                echo "<option value='".$temp_pid."'>".$temp_desc;
        }
        $c_rownum = $c_rownum + 1;
}
echo "</select></td>";

?>

          <tr><td colspan=8>&nbsp;</td></tr>
          <tr><td colspan=8>
    <input type="Submit" name="SEARCHCLIENT" value="Search">&nbsp;
    <input type="reset" name="RESET" value="Reset">
    <input type="hidden" name="calling" value="<?php echo $calling ?>">
        </td></tr>




	</td></tr>
</table>
</body>
<?
include "inc/footer_inc.php";
?>
</HTML>

