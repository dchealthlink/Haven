<?php
session_start();
include "inc/dbconnect.php";
$show_menu="ON";
include("inc/index_header_inc.php");

?>
<html>
<tr><td>
  Available Selections for user : <?php echo $username ?>

<?


if ($debug == 1) {
	DisplayErrMsg(sprintf("db %s debug: %s  -- notify: %s    user_type: %s",$db, $debug, $notify, $usertype)) ;
}
/* =========================== */
	$sql="SELECT table_name as relname, table_desc from application_table ";
/*
	$sql.=" WHERE user_level <='".$userlevel."'";

*/
switch ($usertype) {
case 'admin' :
	$sql.=" where table_type in ('user','admin') ";
	break;

case 'user' :
	$sql.=" where table_type = 'user' ";
	break;
case 'cashier' :
	$sql.=" where table_type = 'user' ";
	break;
case 'su';
case 'vendor' :
default :
};

$sql.=" order by 1";


$result = pg_exec($db,$sql);
if ($debug) {
	DisplayErrMsg(sprintf("Executing %s statement", $sql)) ;
}
if(pg_ErrorMessage($db))
	{
	if ($debug) {
		DisplayErrMsg(sprintf("Error in executing %s statement", $sql)) ;
	}
	DisplayErrMsg(sprintf("Error: %s", pg_ErrorMessage($db))) ;
	};

$rownum = 0;

echo "</td></tr>";
/*
echo "</td><td>&nbsp</td>";
echo "</table>";
*/
echo "<td>";



echo "<table border=0 cellspacing=0 cellpadding=2 bordercolor=#eeeeee width=600>";
echo "<tr align=top>";

?>
<FORM NAME="mainform" METHOD="post" ACTION="<?php $PHP_SELF ?>">
<?

while ($row = pg_fetch_array($result,$rownum))
{
$test=$row[pg_fieldname($result,0)];
if ($row[pg_fieldname($result,1)]) {
	$tbl_desc=$row[pg_fieldname($result,1)];

} else {
	$tbl_desc="Manipulate ".ucfirst(ereg_replace("_"," ",$test))." data";	


}

        $color = "f5f5f5";

                        if (($rownum % 2) == 0) {
                                echo ("\n<TR>");
                        } else {
                                echo ("\n<TR BGCOLOR=$color>");
                        }

echo "<td><b>".ucfirst(ereg_replace("_"," ",$test))."</b></td>";
echo "<td>".$tbl_desc."</td>";	
echo "<td><b><a href='mod_template.php?tablename=".$test."'>Add</a></b></td>";
echo "<td><b><a href='report_template.php?tablename=".$test."'>Report</a></b></td>";
echo "<td><b><a href='view_table.php?tablename=".$test."'>View</a></b></td></tr>";

$rownum = $rownum + 1;
}
echo "</table>";
/* echo "</p>";
include "inc/nav.inc"; */ 
include "inc/footer_inc.php";


?>
</form>
</body>
</HTML>

