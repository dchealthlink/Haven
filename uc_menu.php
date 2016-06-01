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
    <tr><td colspan=2 align=center><b>Use Case Options</b> </td></tr>
<?php


$sql = "SELECT item_cd, item_description, item_translation FROM app_lookup WHERE lookup_table = 'uc_menu' AND (lookup_field = '".$usertype."' or lookup_field = 'ALL') ORDER BY sort_order ";

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
    <tr><td align=center><b>Search Use Cases</b></td><td>Search Use Case Information</td></tr>

</table></td></tr>




<?php
 echo "<tr><td colspan=12>";
 echo "Please Enter Data to Search For</td></tr>";
 echo "<tr><td colspan=12>All Selections will be <em>Logically Anded</em> (e.g. First Name = 'Bill' AND Last Name = 'Smith')</td></tr>";
 echo "<FORM NAME=mainform METHOD=post ACTION=search_uc_gen.php onSubmit='return ValidateForm()'>";
 echo "<tr><td valign=top>";
 echo "<tr><td colspan=6><B>Use Case Information:</B></td></tr>";

 echo "<tr>";
 echo "<td>Use Case ID:</td>";
 echo "<td><input class=pink type=text name=usecaseId maxlength=20 size=15></td>";
 echo "<td>Use Case Name:</td>";
 echo "<td><input class=pink type=text name=usecaseName maxlength=70 size=35></td>";
 echo "</tr>";

 echo "<tr>";
 echo "<td>Priority:</td>";

$csql ="SELECT item_cd, item_description from app_lookup where lookup_table = 'use_case' and lookup_field = 'priority' ORDER BY 1";

$cresult = execSql($db,$csql,$debug);

        echo"<td><select name=\"priority\">";
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

 echo "<td>Actor:</td>";

$csql ="SELECT actor, coalesce(actor_desc, actor) as actor_desc, actor_type from actor_type ORDER BY sort_order";

$cresult = execSql($db,$csql,$debug);

        echo"<td><select name=\"actor\">";
        echo"<option selected value=\"\">";

        $c_rownum=0;

while ($row = pg_fetch_array($cresult,$c_rownum))
{
        list($temp_act, $temp_desc, $temp_type) = pg_fetch_row($cresult,$c_rownum);
        if ($temp_act == $actor) {
                echo "<option selected value='".$temp_act."'>".$temp_desc." (".$temp_desc.")";
        } else {
                echo "<option value='".$temp_act."'>".$temp_desc." (".$temp_desc.")";
        }
        $c_rownum = $c_rownum + 1;
}
echo "</select></td>";

 echo "</tr>";



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

