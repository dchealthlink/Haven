<?php
session_start();
/*	
if(!session_is_registered("userid"))
{
header("Location: index.htm");
exit;
}
*/
include("inc/dbconnect.php");

$ret_code = valid_application_level ($db, $tablename, $usertype);
/*
if ($ret_code == 0) {
	DisplayErrMsg(sprintf("Invalid User Type for table %", $tablename)) ;
	echo "<script>";
	echo "history.back()";
	echo "</script>";
}
*/
include("inc/index_header_inc.php");
?>
<HTML>

  <blockquote>
<tr><td>
  <h1>Select Data</h1>
  <form method="post" action="<?php echo $PHP_SELF?>">

  </b> 
	<b>Select from : </b><? echo $tablename ?><br>
<?
include ("inc/date.php");

 echo "<p><table border=1 cellspacing=0 cellpadding=2 bordercolor=#eeeeee width=600>"; 
/* NEED TO HAVE A PARAMETER PASSED HERE THAT IS THE TABLE NAME */

$sql="SELECT c.relname, a.attname, a.attnum, a.attlen, a.atttypmod, a.attnotnull, t.typname ";
$sql.="FROM pg_class c, pg_attribute a, pg_type t ";
$sql.="WHERE c.relname = '".$tablename."' and c.oid = a.attrelid and a.attnum > 0 and ";
$sql.="a.atttypid = t.oid order by 1, 3";


$result1 = pg_exec($db,$sql);
if(pg_ErrorMessage($db))
	{
	if ($debug) {
		DisplayErrMsg(sprintf("Error in executing %s statement", $sql)) ;
	}
	DisplayErrMsg(sprintf("Error: %s", pg_ErrorMessage($db))) ;
	};

$rownum = 0;
echo "<tr align=top>";
echo "<td><b>Fieldname</b></td>";
echo "<td><b>Include?</b></td>";
echo "<td><b>Sort<br>Order</b></td>";
echo "<td><b>Search Criteria</b></td>";
echo "</tr>";

while ($row = pg_fetch_array($result1,$rownum))
{
$new_array[0][$rownum]=$row[pg_fieldname($result1,1)];
/*
$fieldlabel[$rownum]=$test;
$new_array[0][$rownum]=$test;
*/
echo "<tr align=top>";
echo "<td>".$new_array[0][$rownum]."</td>";

echo "<td><input type=checkbox name=new_array[1][$rownum]></td>";
/*
echo "<td><input type=checkbox name=first[$rowum]></td>";
echo "<td><input type=text size=2 name=second[$rownum]></td>";
echo "<td><input type=text size=40 name=third[$rownum]></td>";
*/
echo "<td><input type=text size=2 name=new_array[2][$rownum]></td>";
echo "<td><input type=text size=40 name=new_array[3][$rownum]></td>";

echo "</tr>";
$rownum = $rownum + 1;
}


if ($submit) {
$sql="SELECT ";
/* $chkrows = count ($fieldlabel); */
$chkrows = count ($new_array[0]);
$singlearray[]= "";
$order_by = "";

$numkeys = 2;
$j = 0;


for ($i = 0; $i < $chkrows; $i++) {

	/* if ($first[$i]) { */
	if ($new_array[1][$i]) {

		/* $sql.=$fieldlabel[$i].", "; */
		$sql.=$new_array[0][$i].", ";

	}
	/* if ($second[$i] && !$singlearray[$second[$i]]) { */
	if ($new_array[2][$i] && !$singlearray[$new_array[2][$i]]) {

		/* $singlearray[$second[$i]] = $fieldlabel[$i]; */
		$singlearray[$new_array[2][$i]] = $new_array[0][$i];
		/* if ($second[$i] > $topval) { */
		if ($new_array[2][$i] > $topval) {
			/* $topval = $second[$i]; */
			$topval = $new_array[2][$i];
		}

	}
	/* if ($third[$i]) { */
	if ($new_array[3][$i]) {
		/* $where_clause.= $fieldlabel[$i]." ".$third[$i]." and "; */
		$where_clause.= $new_array[0][$i]." ".$new_array[3][$i]." and ";
	}
};

for ($i = 0; $i < $topval + 1; $i++) {

 	if ($singlearray[$i]) {  

	$order_by.=$singlearray[$i].",";
	}  

}

if ($order_by) {
	
	$order_by =" ORDER BY ".substr($order_by,0,-1);

}

if ($where_clause) {
	
	$where_clause =" WHERE ".substr($where_clause,0,-5);
}

$sql= substr($sql,0,strlen($sql)-2)." FROM ".$tablename." ".$where_clause." ".$order_by;

$sql = stripslashes($sql);
echo ("Query: <b>\"$sql\"</b><br><br>");
$result = pg_exec($db, $sql);

if ($result) {
$numrows = pg_numrows($result);
$numfields = pg_numfields($result);
printf("Rows: <b>%d </b><br>",$numrows);
} else {
printf("<br>No Rows Returned - possible error<br>");
}

/*
?>
<TABLE BORDER>
<?php
*/
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
echo ("<TD>$val</TD>");
}
echo ("</TR>");
}
}

if ($result) pg_freeresult($result);
};
/*
?>
</table>
<?


    </table>
	<table border=0 cellspacing=0 cellpadding=2 bordercolor=#eeeeee>

*/
?>


	<tr><td colspan=4><input type="Submit" name="submit" value="Submit">&nbsp;
     <input type="Reset" name="clear">&nbsp;
	<input type="hidden" name="tablename" value="<?php echo $tablename?>"></td>
	</tr>
    </p>
  </form>
</blockquote>

<?
echo "<tr><td colspan=4><a href='mod_template.php?tablename=".$tablename."&search=0'>add ".$tablename." data</a></td></tr>";
echo "</table>";
/* include "inc/nav.inc";  */
include "inc/footer_inc.php";
?>

</body>
</HTML>



