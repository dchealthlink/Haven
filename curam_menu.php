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
    <tr><td colspan=2 align=center><b>Curam Schema Options</b> </td></tr>
<?php


$sql = "SELECT item_cd, item_description, item_translation FROM app_lookup WHERE lookup_table = 'curam_menu' AND (lookup_field = '".$usertype."' or lookup_field = 'ALL') ORDER BY sort_order ";

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
    <tr><td align=center><b>Search Curam</b></td><td>Search Curam Schema Information</td></tr>

</table></td></tr>




<?php
 echo "<tr><td colspan=12>";
 echo "Please Enter Data to Search For</td></tr>";
 echo "<tr><td colspan=12>All Selections will be <em>Logically Anded</em> (e.g. First Name = 'Bill' AND Last Name = 'Smith')</td></tr>";
 echo "<FORM NAME=mainform METHOD=post ACTION=search_curam_gen.php onSubmit='return ValidateForm()'>";
 echo "<tr><td valign=top>";
 echo "<tr><td colspan=6><B>Curam Information:</B></td></tr>";

 echo "<tr><td>Table Name:";
 echo "</td>";

$csql ="SELECT ctable_name FROM curam_table ORDER BY 1";

$cresult = execSql($db,$csql,$debug);

        echo"<td><select name=\"curam_cd\">";
        echo"<option selected value=\"\">";

        $c_rownum=0;

while ($row = pg_fetch_array($cresult,$c_rownum))
{
        list($temp_curam_cd) = pg_fetch_row($cresult,$c_rownum);
        if ($temp_curam_cd == $curam_cd) {
                echo "<option selected value='".$temp_curam_cd."'>".$temp_curam_cd;
        } else {
                echo "<option value='".$temp_curam_cd."'>".$temp_curam_cd;
        }
        $c_rownum = $c_rownum + 1;
}
echo "</select></td>";

 echo "<td>Table Part:</td><td><input class=pink type=text name=curam_part maxlength=20 size=15></td>";


 echo "</tr>";



 echo "<tr><td>PK Field:</td><td><input class=pink type=text name=pkfield maxlength=25 size=28></td>";
 echo "<td>PL Query Flag:</td><td>";
 echo "<select name=\"plflag\">";
        echo"<option selected value=\"\">";
        echo"<option value=\"x\">Yes";
 echo "</select></td>";
 echo "</tr>";
 echo "<tr><td>Records >=:</td><td><input class=pink type=text name=fromrecs maxlength=10 size=10></td>";
 echo "<td>Records <=:</td><td><input class=pink type=text name=torecs maxlength=25 size=10></td>";
 echo "</tr>";

?>

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

