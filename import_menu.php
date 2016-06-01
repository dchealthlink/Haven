<?
session_start();
include "inc/dbconnect.php";
include("inc/header_inc.php");
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
    <tr><td colspan=2 align=center><b>Import Options</b> </td></tr>

<?php
$sql="SELECT * from app_lookup where lookup_table = 'import_menu' ";

/*
switch ($usertype) {
        case "admin":
                $sql.= " AND lookup_field in ('user','admin') order by sort_order";
                break;
        case "su":
        case "vendor":
                $sql.= " order by sort_order";
                break;
        default:
                $sql.= " AND (lookup_field = '".$usertype."' OR lookup_field = 'ALL') order by sort_order";
        }
*/

$result = execSql($db,$sql,$debug);

echo "<table border=0 cellspacing=0 cellpadding=2 bordercolor=#eeeeee width=600>";
$rownum = 0;
while ($row = pg_fetch_array($result,$rownum))
{
$test=$row[pg_fieldname($result,0)];

echo "<tr><td align=center><b><a href='".$row[pg_fieldname($result,4)]."'>".$row[pg_fieldname($result,2)]."</a></b></td><td>".$row[pg_fieldname($result,3)]."</td></tr>";

$rownum = $rownum + 1;
}

?>

    <tr><td align=center><b>---------------</a></b></td><td align=left>------------------------------</td></tr>
    <tr><td align=center><b>Other Import Functionality</b><td>TBD</b></td>
    </table>
	</td></tr>

</body>
<?
include "inc/footer_inc.php";
?>
</table>
</HTML>

