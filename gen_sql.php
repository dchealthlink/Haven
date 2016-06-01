<?
session_start();
include("inc/dbconnect.php");

if ($SAVEQUERY) {

session_register("query_value");
$query_value=$sql;
header("Location: save_query.php"); 
}
if ($EXPORTQUERY) {

session_register("query_value");
$query_value=$sql;
header("Location: query_wizard_export.php");
}
if ($NEWQUERY) {

session_unregister("query_value");
header("Location: gen_select.php");
}

include("inc/header_inc.php");
/*
if(!session_is_registered("ownerid"))
{
header("Location: index.htm");
exit;
}
if ($client_name !== 'admin')
{
header("Location: index.htm");
exit;
}
	*/
?>
<HTML>
<tr><td>
  <blockquote>
   <h1>Query Results</h1>
<form method="post" action="<?php echo $PHP_SELF ?>">
<?php
/* <form method="post" action="save_query.php"> */

$sql = stripslashes($sqlstring);
echo ("Query: <b>\"$sql\"</b><br>\n");

$sql = ereg_replace(";"," ",$sql);
$transtype = explode(" ",trim($sql));
$numelements = count($transtype);

switch (strtolower($transtype[0])) {
	case 'select' :
		for ($idx = 0; $idx < $numelements; ++$idx) {
			if (strtolower($transtype[$idx]) == 'from') {	
				$from_table = $transtype[$idx + 1];
			}
			$table_where = " where table_name = '".$from_table."'"; 
		}
		break;
	case 'update' :
		if ($formproc == "gen_select") {
			$error_cd = '1';
		} 
			$table_where = " where table_name = '".strtolower($transtype[1])."'"; 
		break;
	case 'delete' :
		if ($formproc == "gen_select") {
			$error_cd = '1';
		} 
			$table_where = " where table_name = '".strtolower($transtype[2])."'"; 
		break;
	default:
			$error_cd = '1';
			$table_where = " where 1 = 1"; 
	};

switch ($usertype) {
	case 'user' :
			$owner_where = " and table_type ='application' ";
		break;
	case 'admin' :
			$owner_where = " and table_type !='su' ";
		break;
	case 'vendor' :
	case 'su' :
	default:
			$owner_where = " ";
	};

if ($error_cd !== '1') {
$table_check = "SELECT * from application_table ".$table_where.$owner_where; 

$check_result = pg_exec ($db, $table_check);
if ($debug) {
	DisplayErrMsg(sprintf("Executing: %s for %s", $table_check, $owner_type));
}

if (pg_ErrorMessage($db)) {
	DisplayErrMsg(sprintf("Error executing: %s", $table_check));
	DisplayErrMsg(sprintf("Error: %s", pg_ErrorMessage($db)));
	};

$unique_cnt = pg_numrows($check_result);	
}
/* if (strtolower($transtype[0]) !== "select" and $formproc == "gen_select") { 
*/
if ($error_cd == 1 or $unique_cnt == 0 AND $usertype != 'su') {
	echo("<br><b>Invalid Action - possible error</b><br>");
echo ("<br>Use the [Back] button on your browser to go back to the search form<br>");

} else {

$result = pg_exec($db, $sql);

if ($result) {
	$numrows = pg_numrows($result);
	$numfields = pg_numfields($result);
	printf("Rows Returned: <b>%d </b>\n",$numrows);
	if ($transtype[0] !== "select") {
		$rowsaffected = pg_cmdTuples($result);
		printf("<br>Rows Affected: <b>%d </b><br>",$rowsaffected);
	}
} else {
	Printf("<br>No Rows Returned - possible error<br>");
}

echo ("<br>Use the [Back] button on your browser to go back to the search form<br>");
 echo "<br>"; 
echo "<table>"; 
if ($result) {
	echo("\n<TR BGCOLOR=\"f5f5f5\">");
	for ($i=0;$i<$numfields;$i++) {
	$fldname = pg_fieldname($result,$i);
	$fldname = ereg_replace("_","<br>",$fldname);
	echo ("<Td><b>$fldname</b></Td>");
}

echo ("</TR>");
$color = "f5f5f5";

for ($i=0;$i<$numrows;$i++) {

	if (($i % 2) == 0) {
		echo ("\n<TR>");
	} else {
		echo ("\n<TR BGCOLOR=$color>");
	}
	$rowarr = pg_fetch_row($result,$i);
	for ($j=0;$j<$numfields;$j++) {
		$val = $rowarr[$j];
		if ($val == "") {
 			$val = "&nbsp;";
		} 

 		if (pg_fieldname($result,$j) == 'password')  {
			echo "<td>**********</td>";
		} else {
			echo "<td>$val</td>";
		}

	}
echo ("</TR>");
}
}
echo ("<input type=hidden name=sql value='".$sql."'>");


if ($result) pg_freeresult($result);
?>
<!-- </table> -->

    <tr><td>&nbsp</td></tr>
<tr><td colspan=6>
    <input class="gray" type="Submit" name="SAVEQUERY" value="Save Query">&nbsp;
    <input class="gray" type="Submit" name="EXPORTQUERY" value="Export Query">
    <input class="gray" type="Submit" name="NEWQUERY" value="New Query">
</td></td></table> 
   </p>
  </form>


<?
}

include "inc/footer_inc.php";
?>
</body>
</HTML>
